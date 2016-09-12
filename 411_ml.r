rm(list=ls())
library(hash)
library(cluster)
library(sets)

getBusId2Category <- function(bus){
  bus2cate <- hash()
  for(i in 1:dim(bus)[1]){
    busId <- toString(bus[i,1])
    added <- FALSE
    for(j in 4:dim(bus)[2]){
      if(bus[i,j]==1){
        if(!added){
          added <- TRUE
          bus2cate[busId] <- c(j)
        }else{
          bus2cate[busId] <- c(j, values(bus2cate, busId))
        }
      }
    }
  }
  bus2cate
}

getBusId2Rating <- function(bus){
  bus2Rate <- hash()
  for(i in 1:dim(bus)[1]){
    bus2Rate[toString(bus[i,1])] <- bus[i,3]
  }
  bus2Rate
}

#added -unexcuted------------------------------------
#------------------------------------------------

busFile <- 'bus_corrected.csv'
userFile <- 'users-ml.csv.csv'
reviewFile <- 'reviews-ml-nobias.csv.csv'

busRaw <- read.csv(busFile, header = TRUE)
busRaw[is.na(busRaw)] <- 0  #deal with NA in categories
busRaw[,3] <- as.numeric(busRaw[,3])  #rating should be number
userRaw <- read.csv(userFile, header = TRUE)
reviewRaw <- read.csv(reviewFile, header = TRUE)
reviewRaw[,6] <- as.numeric(reviewRaw[,6])  #rating should be number
tmp<-colnames(reviewRaw)
tmp[5]<-"UR-RR"
tmp[6]<-"UR-BR"
colnames(reviewRaw)<-tmp
reviewRaw[,5] <- as.numeric(reviewRaw[,5])  # should be number

user2Rate <- hash(userRaw[,1], userRaw[,2])
bus2cate <- getBusId2Category(busRaw)  #hashtable, key=businessId, value=categories
bus2rate <- getBusId2Rating(busRaw)

#change user->business review to user->business preference
prefReview <- reviewRaw
for(i in 1:dim(reviewRaw)[1]){
  busId <- toString(reviewRaw[i,4])
  userId <- toString(reviewRaw[i,1])
  if(has.key(busId, bus2rate) && has.key(userId, user2Rate) ){
    prefReview[i,5] <- values(user2Rate, userId) - reviewRaw[i,6]
    prefReview[i,6] <- values(bus2rate, busId) - reviewRaw[i,6]
  }else{
    prefReview[i,5] <- NA  #invalid business id or user id
    prefReview[i,6] <- NA  #invalid business id or user id
  }
}
naCount <- sum(is.na(prefReview[,6]))
prefReview <- prefReview[!is.na(prefReview[,6]),] #drop review with invalid id
#=====================================================================
#build user->category hash
user2cateRate <- hash()
user2cateCount <- hash()
emptyCate <- rep(0, 109-4+1)  #large enough to store all category data
for(i in 1:dim(prefReview)[1]){
  userId <- toString(prefReview[i,1])
  busId <- toString(prefReview[i,4])
  if(has.key(busId, bus2cate)){ #the reviewed business has category
    if(!has.key(userId, user2cateCount)){  #user not exist, create user
      user2cateRate[userId] <- emptyCate
      user2cateCount[userId] <- emptyCate
    }
    category <- values(bus2cate, busId)
    # update user's hit for the cat
    for(cate in category){
      tmp <- values(user2cateRate, userId)
      tmp[cate-3] <- tmp[cate-3] + as.numeric(prefReview[i,6])  + as.numeric(prefReview[i,5])
      user2cateRate[userId] <- tmp
      tmp <- values(user2cateCount, userId)
      tmp[cate-3] <- tmp[cate-3] + 1 
      user2cateCount[userId] <- tmp
    }
  }
}

#build user -> category review
users <- ls(user2cateCount)
user2cateMean <- hash()
for(user in users){
  user2cateMean[user] <- values(user2cateRate, user) / values(user2cateCount, user)
}

#build covariance
dims <- 109-4+1
cross <- matrix(0, dims, dims)
times <- matrix(0, dims, dims)
for(user in users){
  #average rating of user on cate i
  score <- values(user2cateMean, user)
  valid <- which(!is.na(score))
  for(i in 1:length(valid)){
    for(j in i:length(valid)){
      cross[valid[i],valid[j]] = cross[valid[i],valid[j]] + score[valid[i]] * score[valid[j]]
      times[valid[i],valid[j]] = times[valid[i],valid[j]] + 1
    }
  }
}

covar <- cross/times


f<-function(m){
  m[lower.tri(m)]<-t(m)[lower.tri(m)]
  m
}
cjy<-covar
cjy[is.na(cjy)] <- -3
cjy<-f(cjy)

rowmins<-apply(cjy,1,min)
colmins<-apply(cjy,2,min)
#keep<-which(colmins!=0)
#newcolmins<-0
#for (i in keep ){
  #newcolmins<-c(newcolmins,colmins[i])  
#}
#newcolmins<-newcolmins[-1]

# keep<-which(rowmins!=0)
# newrowmins<-0
# for (i in keep ){
#   newrowmins<-c(newrowmins,rowmins[i])  
# }
# newrowmins<-newrowmins[-1]
#summary(newcolmins)

# apply(tmp,MARGIN = 2,FUN=function(x)(x-min(x)) / diff(range(x)) )
# scale(tmp, center///)
# cjy[27,49] <- 13.227
# cjy[49,27] <- 13.227
# cjy[27,49] <- 9
# cjy[49,27] <- 9
library(spatstat) 
plot(im(cjy[nrow(cjy):1,]), main="Correlation Matrix Map")

#don't excute all===================================
dissim1<-(9-abs(cjy))/2 
dissim2<-(1-cjy)/2
dissim2<-sqrt((82-cjy^2))
tmp <- as.data.frame(dissim2)
#====================================================
cateName <- colnames(busRaw[,4:109])
colnames(tmp) <- cateName
dist <- as.dist(tmp)
plot(dist)
plot(agnes(dist))

# dis1<-as.dist(dissim1)
# dis2<-as.dist(dissim2)
# round(dist2,4)
# plot(dis1)
# plot(dis2)

plot(hclust(dist, method = "median" ), main="Dissimilarity = (9 - correlation)/2 median",xlab="")
fit <- hclust(dist, method="median") 
plot(fit) # display dendogram
groups <- cutree(fit, k=9) # cut tree into 5 clusters
# draw dendogram with red borders around the 5 clusters 
rect.hclust(fit, k=9, border="red")


library(Hmisc)
plot( varclus(cjy, similarity="spearman"),main="varclus w/ spearman similarity" )
plot( varclus(cjy, similarity="pearson") )
plot(hclust(dis2), main="Dissimilarity2",xlab="")

plot(hclust(dist), main="zxw",xlab="")

dist <- max(cjy) - cjy
k <- 12
pamx <- pam(as.dist(dist), k, diss=TRUE)
summary(pamx)
plot(pamx)
clustering <- pamx$clustering
size <- rep(0, k)
for(i in 1:k){
  size[i] <- sum(clustering == i)
}
size

cateName <- colnames(busRaw[,4:109])
classnames <- rep('', k)
for(i in 1:k){
  class <- cateName[which(clustering==i)]
  for(name in class){
    classnames[i] <- paste(classnames[i], name, sep=', ')
  }
}
classnames


#x <- rbid(cbind(rnorm(10,0,0.5), rnorm(10,0,0.5)),
           #cbind(rnorm(15,5,0.5), rnorm(15,5,0.5)))
#dist <- dist(x, method = "manhattan")
#pamx <- pam(dist, 2, diss=TRUE)
#pamx # Medoids: '7' and '25' ...
#summary(pamx)
#plot(pamx)

