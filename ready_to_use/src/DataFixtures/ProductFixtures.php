<?php


namespace App\DataFixtures;


use App\Entity\Brand;
use App\Entity\Feature;
use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Wharehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $brand = new Brand();
//        $brand->setName('Apple');
//        $brand->setDescription("Apple est créé le 1 er avril 1976 dans la maison d'enfance de Steve Jobs à Los Altos, puis constituée sous forme de société le 3 janvier 1977.Elle prend diverses facettes coordonnées avec l'évolution du monde informatique qu'elle précède, partant d'un monde sans ordinateur personnel à une société du XXI e siècle interconnectée par l'intermédiaire de terminaux fixes et mobiles.");
//        $brand->setFoundationDate(new \DateTime('01-01-1977'));
//        $brand->setLocation('Cupertino, USA');
//        $manager->persist($brand);
//
//        $feature = new Feature();
//        $feature->setBattery(250);
//        $feature->setCamera("16MP");
//        $feature->setGraphicCard("RTX 2080");
//        $feature->setHardDisk("256GO");
//        $feature->setOsVersion("V10.1");
//        $feature->setProcessor("A11");
//        $feature->setRam(6);
//        $feature->setScreenSize('5"8');
//        $feature->setTactile(true);
//        $manager->persist($feature);
//
//        $model = new Model();
//        $model->setName('Iphone 8');
//        $model->setDescription("L'iPhone 8 et l'iPhone 8 Plus sont deux smartphones, modèles de la 11ᵉ génération d'iPhone de la marque Apple.");
//        $model->setReleaseDate(new \DateTime('09-01-2017'));
//        $model->setFeature($feature);
//        $model->setBrand($brand);
//        $manager->persist($model);
//
//        $warehouse = new Wharehouse();
//        $warehouse->setAddress("33 rue Corot");
//        $warehouse->setCity("Ville d'Avray");
//        $manager->persist($warehouse);
//
//        $product = new Product();
//        $product->setWharehouse($warehouse);
//        $product->setDescription("Un super Iphone !!!!");
//        $product->setPrice(650);
//        $product->setDepositDate(new \DateTime('01-01-1977'));
//        $product->setModel($model);
//        $product->setProductCondition(2);
//        $manager->persist($product);
//
//        $brand2 = new Brand();
//        $brand2->setName('Samsung');
//        $brand2->setDescription("Samsung Electronics est une entreprise spécialisée dans la fabrication de produits électroniques. C'est une filiale à 100 % du Groupe Samsung, l'un des principaux chaebols coréens. En 2019, elle emploie 308 745 personnes et est la 13ᵉ plus importante société dans le monde d'après le classement Forbes Global 2000");
//        $brand2->setFoundationDate(new \DateTime('13-01-1969'));
//        $brand2->setLocation('Suwon, Corée du Sud');
//        $manager->persist($brand2);
//
//        $feature2 = new Feature();
//        $feature2->setBattery(500);
//        $feature2->setCamera("64MP");
//        $feature2->setGraphicCard("Mali G78");
//        $feature2->setHardDisk("512GO");
//        $feature2->setOsVersion("Android 11");
//        $feature2->setProcessor("Exynos 2100, 2.9GHz");
//        $feature2->setRam(12);
//        $feature2->setScreenSize('6"2');
//        $feature2->setTactile(true);
//        $manager->persist($feature2);
//
//        $model2 = new Model();
//        $model2->setName('Galaxy S21 Ultra 5G');
//        $model2->setDescription("Dernier sorti de chez Samsung avec la 5G !!!!");
//        $model2->setReleaseDate(new \DateTime('14-01-2021'));
//        $model2->setFeature($feature2);
//        $model2->setBrand($brand2);
//        $manager->persist($model2);
//
//        $product2 = new Product();
//        $product2->setWharehouse($warehouse);
//        $product2->setDescription("Un super portable Samsung, à peine utilisé");
//        $product2->setPrice(1000);
//        $product2->setDepositDate(new \DateTime('06-06-2021'));
//        $product2->setModel($model2);
//        $product2->setProductCondition(1);
//        $manager->persist($product2);
//
//        $manager->flush();

    }
}