<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $name = ['Acer Nitro 5', 'Dell G3', 'Macbook M1', 'Asus TUF F15', 'Asus ROG G513', 'Alienware G15'];
        $image = ['images/pr1.png', 'images/pr2.png', 'images/pr3.png', 'images/pr4.png', 'images/pr5.png'];
        $warranty = ['1 year', '2 years', '3 years', '4 years', '5 years'];
        $gift = ['Gaming mouse', 'Headphones', 'Gaming Keyboard', 'RAM', 'Backpack'];
        $model = ['GTX1650 and i5 12450h', 'RTX3060 and i7 12750h', 'RTX3050 and i7 11800h'];

        $title = ['Gaming Laptop', 'Gaming PC', 'Office PC', 'Computer Component', 'Display Monitor', 'Gears', 'Music and Sound', 'Accessory'];

        for ($i = 0; $i <= 7; $i++) {
            $category = new Category;
            $category->setTitle($title[$i]);
            $manager->persist($category);
        }

        for ($i = 0; $i <= 30; $i++) {
            $nam = array_rand($name, 1);
            $img = array_rand($image, 1);
            $war = array_rand($warranty, 1);
            $gf = array_rand($gift, 1);
            $mod = array_rand($model, 1);

            $product = new Product;
            $product->setCategory($category)
                ->setName($name[$nam])
                ->setPrice(rand(4000, 1500))
                ->setStock(rand(0, 100))
                ->setImage($image[$img])
                ->setWarranty($warranty[$war])
                ->setGift($gift[$gf])
                ->setModel($model[$mod]);

            $manager->persist($product);
        }
        $manager->flush();
    }
}
