<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\Model;
use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function load(ObjectManager $manager)
    {
        $brand = new Brand();
        $brand->setName('Apple');
        $brand->setDescription("Apple est créé le 1 er avril 1976 dans la maison d'enfance de Steve Jobs à Los Altos, puis constituée sous forme de société le 3 janvier 1977.Elle prend diverses facettes coordonnées avec l'évolution du monde informatique qu'elle précède, partant d'un monde sans ordinateur personnel à une société du XXI e siècle interconnectée par l'intermédiaire de terminaux fixes et mobiles.");
        $brand->setFoundationDate(new \DateTime('01-01-1977'));
        $brand->setLocation('Cupertino, USA');
        $manager->persist($brand);

        $feature = new Feature();
        $feature->setBattery(1);
        $feature->setCamera("16MP");
        $feature->setGraphicCard("RTX 2080");
        $feature->setHardDisk("256GO");
        $feature->setOsVersion("V10.1");
        $feature->setProcessor("A11");
        $feature->setRam(6);
        $feature->setScreenSize('5"8');
        $feature->setTactile(true);
        $manager->persist($feature);

        $category = new Category();
        $category->setName('Smartphone');
        $category->setDescription('Liste des smartphones');
        $manager->persist($category);

        $model = new Model();
        $model->setName('Iphone 8');
        $model->setDescription("L'iPhone 8 et l'iPhone 8 Plus sont deux smartphones, modèles de la 11ᵉ génération d'iPhone de la marque Apple.");
        $model->setReleaseDate(new \DateTime('09-01-2017'));
        $model->setFeature($feature);
        $model->setBrand($brand);
        $model->setCategory($category);
        $model->setShowBatteryField(true);
        $model->setShowCameraField(true);
        $model->setShowGraphicCardField(true);
        $model->setShowHardDiskField(true);
        $model->setShowOsVersionField(true);
        $model->setShowProcessorField(true);
        $model->setShowRamField(true);
        $model->setShowScreenField(true);
        $model->setShowTactileField(true);
        $manager->persist($model);

        $offer = new Offer();
        $offer->setProductCondition(1);
        $offer->setAmount(599);
        $offer->setModel($model);
        $manager->persist($offer);

        $offer = new Offer();
        $offer->setProductCondition(2);
        $offer->setAmount(699);
        $offer->setModel($model);
        $manager->persist($offer);

        $order = new Order();
        $order->setStatus(0);
        $order->setRequestDate(new \DateTime());
        $orderedBy = $this->userRepository->findOneBy(['username' => 'test']);
        $order->setOrderedBy($orderedBy);

        $product = new Product();
        $product->setPrice($offer->getAmount());
        $product->setDescription('lorem ipsum');
        $product->setProductCondition(1);
        $product->setDepositDate(new \DateTime());
        $product->setFeature($feature);
        $product->setModel($model);
        $manager->persist($product);

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setOrderRef($order);
        $manager->persist($orderItem);

        $order->addProduct($orderItem);
        $manager->persist($order);

        $manager->flush();
    }
}
