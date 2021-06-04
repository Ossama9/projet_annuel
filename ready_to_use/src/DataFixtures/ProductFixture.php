<?php


namespace App\DataFixtures;


use App\Entity\Brand;
use App\Entity\Feature;
use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Wharehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brand = new Brand();
        $brand->setName('Apple');
        $brand->setDescription("Apple est créé le 1 er avril 1976 dans la maison d'enfance de Steve Jobs à Los Altos, puis constituée sous forme de société le 3 janvier 1977.Elle prend diverses facettes coordonnées avec l'évolution du monde informatique qu'elle précède, partant d'un monde sans ordinateur personnel à une société du XXI e siècle interconnectée par l'intermédiaire de terminaux fixes et mobiles.");
        $brand->setFoundationDate(new \DateTime('01-01-1977'));
        $brand->setLocation('Cupertino, USA');
        $manager->persist($brand);

        $feature = new Feature();
        $feature->setBattery(250);
        $feature->setCamera("16MP");
        $feature->setGraphicCard("RTX 2080");
        $feature->setHardDisk("256GO");
        $feature->setOsVersion("V10.1");
        $feature->setProcessor("A11");
        $feature->setRam(6);
        $feature->setScreenSize('5"8');
        $feature->setTactile(true);
        $manager->persist($feature);

        $model = new Model();
        $model->setName('Iphone 8');
        $model->setDescription("L'iPhone 8 et l'iPhone 8 Plus sont deux smartphones, modèles de la 11ᵉ génération d'iPhone de la marque Apple.");
        $model->setReleaseDate(new \DateTime('09-01-2017'));
        $model->setFeature($feature);
        $model->setBrand($brand);
        $manager->persist($model);

        $warehouse = new Wharehouse();
        $warehouse->setAddress("33 rue Corot");
        $warehouse->setCity("Ville d'Avray");
        $manager->persist($warehouse);

        $product = new Product();
        $product->setWharehouse($warehouse);
        $product->setDescription("Un super Iphone !!!!");
        $product->setPrice(650);
        $product->setDepositDate(new \DateTime('01-01-1977'));
        $product->setModel($model);
        $product->setProductCondition(2);
        $manager->persist($product);

        $manager->flush();

    }
}