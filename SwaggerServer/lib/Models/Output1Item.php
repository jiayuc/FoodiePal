<?php
/*
 * Output1Item
 */
namespace SwaggerServer\lib\Models;

/*
 * Output1Item
 */
class Output1Item {
    /* @var double $stars  */
    private $stars;
/* @var int $categoryBagels  */
    private $categoryBagels;
/* @var int $categoryDelis  */
    private $categoryDelis;
/* @var int $categorySandwiches  */
    private $categorySandwiches;
/* @var int $categoryMexican  */
    private $categoryMexican;
/* @var int $categoryPizza  */
    private $categoryPizza;
/* @var int $categoryBurgers  */
    private $categoryBurgers;
/* @var int $categoryBeerWineSpirits  */
    private $categoryBeerWineSpirits;
/* @var int $categoryBars  */
    private $categoryBars;
/* @var int $categoryNightlife  */
    private $categoryNightlife;
/* @var int $categoryLounges  */
    private $categoryLounges;
/* @var int $categoryBuffets  */
    private $categoryBuffets;
/* @var int $categoryDimSum  */
    private $categoryDimSum;
/* @var int $categoryChinese  */
    private $categoryChinese;
/* @var int $categoryFastFood  */
    private $categoryFastFood;
/* @var int $categoryBreweries  */
    private $categoryBreweries;
/* @var int $categoryAmericanNew  */
    private $categoryAmericanNew;
/* @var int $categoryItalian  */
    private $categoryItalian;
/* @var int $categoryCheesesteaks  */
    private $categoryCheesesteaks;
/* @var int $categoryPubs  */
    private $categoryPubs;
/* @var int $categoryBritish  */
    private $categoryBritish;
/* @var int $categoryJapanese  */
    private $categoryJapanese;
/* @var int $categoryBakeries  */
    private $categoryBakeries;
/* @var int $categoryAmericanTraditional  */
    private $categoryAmericanTraditional;
/* @var int $categoryDiveBars  */
    private $categoryDiveBars;
/* @var int $categoryCoffeeTea  */
    private $categoryCoffeeTea;
/* @var int $categoryWineBars  */
    private $categoryWineBars;
/* @var int $categoryHotDogs  */
    private $categoryHotDogs;
/* @var int $categoryBreakfastBrunch  */
    private $categoryBreakfastBrunch;
/* @var int $categoryDiners  */
    private $categoryDiners;
/* @var int $categorySushiBars  */
    private $categorySushiBars;
/* @var int $categoryTexMex  */
    private $categoryTexMex;
/* @var int $categorySportsBars  */
    private $categorySportsBars;
/* @var int $categoryEthnicFood  */
    private $categoryEthnicFood;
/* @var int $categorySpecialtyFood  */
    private $categorySpecialtyFood;
/* @var int $categoryMediterranean  */
    private $categoryMediterranean;
/* @var int $categoryIceCreamFrozenYogurt  */
    private $categoryIceCreamFrozenYogurt;
/* @var int $categoryFishChips  */
    private $categoryFishChips;
/* @var int $categoryKorean  */
    private $categoryKorean;
/* @var int $categoryDonuts  */
    private $categoryDonuts;
/* @var int $categorySeafood  */
    private $categorySeafood;
/* @var int $categoryCajunCreole  */
    private $categoryCajunCreole;
/* @var int $categoryVegan  */
    private $categoryVegan;
/* @var int $categoryGreek  */
    private $categoryGreek;
/* @var int $categoryCaribbean  */
    private $categoryCaribbean;
/* @var int $categoryVegetarian  */
    private $categoryVegetarian;
/* @var int $categoryBarbeque  */
    private $categoryBarbeque;
/* @var int $categoryMiddleEastern  */
    private $categoryMiddleEastern;
/* @var int $categoryJuiceBarsSmoothies  */
    private $categoryJuiceBarsSmoothies;
/* @var int $categoryTaiwanese  */
    private $categoryTaiwanese;
/* @var int $categoryCafes  */
    private $categoryCafes;
/* @var int $categoryFrench  */
    private $categoryFrench;
/* @var int $categoryLatinAmerican  */
    private $categoryLatinAmerican;
/* @var int $categoryAsianFusion  */
    private $categoryAsianFusion;
/* @var int $categoryFoodStands  */
    private $categoryFoodStands;
/* @var int $categoryIndian  */
    private $categoryIndian;
/* @var int $categoryPakistani  */
    private $categoryPakistani;
/* @var int $categoryChampagneBars  */
    private $categoryChampagneBars;
/* @var int $categoryThai  */
    private $categoryThai;
/* @var int $categoryHawaiian  */
    private $categoryHawaiian;
/* @var int $categoryFilipino  */
    private $categoryFilipino;
/* @var int $categoryVietnamese  */
    private $categoryVietnamese;
/* @var int $categorySpanish  */
    private $categorySpanish;
/* @var int $categorySteakhouses  */
    private $categorySteakhouses;
/* @var int $categoryKosher  */
    private $categoryKosher;
/* @var int $categorySouthern  */
    private $categorySouthern;
/* @var int $categoryDesserts  */
    private $categoryDesserts;
/* @var int $categoryChickenWings  */
    private $categoryChickenWings;
/* @var int $categoryIrish  */
    private $categoryIrish;
/* @var int $categoryGlutenFree  */
    private $categoryGlutenFree;
/* @var int $categorySoulFood  */
    private $categorySoulFood;
/* @var int $categoryGerman  */
    private $categoryGerman;
/* @var int $categoryGelato  */
    private $categoryGelato;
/* @var int $categoryLocalFlavor  */
    private $categoryLocalFlavor;
/* @var int $categoryAfrican  */
    private $categoryAfrican;
/* @var int $categoryCreperies  */
    private $categoryCreperies;
/* @var int $categoryMongolian  */
    private $categoryMongolian;
/* @var int $categoryDoItYourselfFood  */
    private $categoryDoItYourselfFood;
/* @var int $categorySoup  */
    private $categorySoup;
/* @var int $categoryChocolatiersShops  */
    private $categoryChocolatiersShops;
/* @var int $categoryTurkish  */
    private $categoryTurkish;
/* @var int $categoryTapasBars  */
    private $categoryTapasBars;
/* @var int $categorySeafoodMarkets  */
    private $categorySeafoodMarkets;
/* @var int $categoryFondue  */
    private $categoryFondue;
/* @var int $categoryCouriersDeliveryServices  */
    private $categoryCouriersDeliveryServices;
/* @var int $categoryFoodTrucks  */
    private $categoryFoodTrucks;
/* @var int $categorySalad  */
    private $categorySalad;
/* @var int $categoryPolish  */
    private $categoryPolish;
/* @var int $categoryHookahBars  */
    private $categoryHookahBars;
/* @var int $categoryFruitsVeggies  */
    private $categoryFruitsVeggies;
/* @var int $categoryCambodian  */
    private $categoryCambodian;
/* @var int $categoryTapasSmallPlates  */
    private $categoryTapasSmallPlates;
/* @var int $categoryPeruvian  */
    private $categoryPeruvian;
/* @var int $categoryTeaRooms  */
    private $categoryTeaRooms;
/* @var int $categoryHerbsSpices  */
    private $categoryHerbsSpices;
/* @var int $categoryShavedIce  */
    private $categoryShavedIce;
/* @var int $categoryRussian  */
    private $categoryRussian;
/* @var int $categoryPianoBars  */
    private $categoryPianoBars;
/* @var int $categoryBedBreakfast  */
    private $categoryBedBreakfast;
/* @var int $categoryAfghan  */
    private $categoryAfghan;
/* @var int $categoryModernEuropean  */
    private $categoryModernEuropean;
/* @var int $categoryInternetCafes  */
    private $categoryInternetCafes;
/* @var int $categoryBrazilian  */
    private $categoryBrazilian;
/* @var int $categoryArgentine  */
    private $categoryArgentine;
/* @var int $categoryCocktailBars  */
    private $categoryCocktailBars;
/* @var int $categoryLaotian  */
    private $categoryLaotian;
/* @var int $categoryLebanese  */
    private $categoryLebanese;
}
