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
        $name = [
            'Dell G15',
            'HP Omen 15',
            'MSI Katana',
            'Acer Predator Helios 300',
            'Asus ROG Zephyrus 17',
            'Phantom i3060Ti',
            'Viper i1660s',
            'Phantom Plus a3060Ti',
            'Phantom Plus i3080',
            'Titan Plus i4090',
            'Homework Athlon',
            'Homework R3',
            'Homework i3-GT730',
            'Homework i3 Gen 12',
            'Homework i5 Gen 12',
            'Asus ROG Z790',
            'Geforce RTX4090',
            'Intel Core i9 13900k',
            'Asus ROG Thor 1000w',
            'Gigabyte Aorus 5TB',
            'Asus ROG 49"',
            'Samsung Odyssey 4K',
            'SamSung Odyssey Neo',
            'Gigabyte 56"',
            'Cooler master 34"',
            'Cosair Hustman Elite',
            'Steelseries Mamba Ilite',
            'Logitech G502 X',
            'Razer Naga V2',
            'Ducky Pro X',
            'Logitech G735',
            'HyperX Orbit S',
            'ROG Centra',
            'Razer Sound Bar',
            'Vander HOTCH BT',
            'Ethenet Capable',
            'Phone Charging Adapter',
            'Charging Capable',
            'Backpack',
            'ROG Wifi Rounter'
        ];
        $image = [
            'images/gaming_laptop/Dell G15.png',
            'images/gaming_laptop/HP omen 15.png',
            'images/gaming_laptop/MSI katana.png',
            'images/gaming_laptop/Predator H300.png',
            'images/gaming_laptop/ROG Z17.png',
            'images/gaming_PC/PC gaming1.png',
            'images/gaming_PC/PC gaming2.png',
            'images/gaming_PC/PC gaming3.png',
            'images/gaming_PC/PC gaming4.png',
            'images/gaming_PC/PC gaming5.png',
            'images/office_PC/PC_VP1.png',
            'images/office_PC/PC_VP2.png',
            'images/office_PC/PC_VP3.png',
            'images/office_PC/PC_VP4.png',
            'images/office_PC/PC_VP5.png',
            'images/pc_component/Component1.png',
            'images/pc_component/Component2.png',
            'images/pc_component/Component3.png',
            'images/pc_component/Component4.png',
            'images/pc_component/Component5.png',
            'images/screen/Screen1.png',
            'images/screen/Screen2.png',
            'images/screen/Screen3.png',
            'images/screen/Screen4.png',
            'images/screen/Screen5.png',
            'images/gears/gear1.png',
            'images/gears/gear2.png',
            'images/gears/gear3.png',
            'images/gears/gear4.png',
            'images/gears/gear5.png',
            'images/music_sound/sound1.png',
            'images/music_sound/sound2.png',
            'images/music_sound/sound3.png',
            'images/music_sound/sound4.png',
            'images/music_sound/sound5.png',
            'images/accessory/accessory1.png',
            'images/accessory/accessory2.png',
            'images/accessory/accessory3.png',
            'images/accessory/accessory4.png',
            'images/accessory/accessory5.png'
        ];

        $warranty = ['1 years', '2 years', '3 years', '4 years'];


        $gift = ['Fuhlen G90 Black Mouse', 'Fuhlen D87s RGB Optical Keyboard', 'DareU EH416 RGB JHeadphones'];


        $model = [
            'GTX1650 and i5 12450h',
            'RTX3060 and i7 12750h',
            'RTX3050 and i7 11800h',
            'RTX3080 and i7 11800h',
            'GTX1660 Ti and i7 10750h',
            'RTX3060 Ti and i7 12700F',
            'GTX1660 Super and i5 12400F',
            'RTX3060 Ti and Ryzen 7 5700X',
            'RTX3080 and i7 12700K',
            'RTX4090 and i9 13900K',
            'ATH 3000G with ',
            'Ryzen 3 3200G',
            'i3 10105F and GT730',
            'i3 12000',
            'i5 12400',
            'AI COOLING II, 7800+ MT/s, AEMP II, XMP',
            '24GB GDDR6X with DLSS 3 buffed-up design',
            '24 cores 36 threads, Turbo: 5.8GHz',
            'Axial-tech fan with PWM control',
            'Read: 3200mb/s Write: 3300mb/s',
            'OLED 4K 138Hz 1ms G-Sync',
            'VA 4K 165Hz Quantum Mini-LED',
            'VA 2K 240Hz Gsync',
            '2K 144Hz HDR400',
            '2K 165Hz Gsync compatible',
            'Cherry Mx Blue, Brown, Silver with RGB led light',
            'OmniPoint Adjustable Mechanical Switch, RGB Dynamic',
            'HERO 25K, 100 - 25.600 dpi, 106 g',
            'Wireless (2.4GHz) / Bluetooth, Razer Chroma RGB',
            'One 3 Fullsize Daybreak, PBT Double-shot',
            'Over-ear, LIGHTSPEED / Bluetooth, Driver 40 mm',
            'Stereo+3D Audio+Headtracking, USB Type A, USB Type C, 3.5mm',
            '20Hz - 20KHz, Omnidirectional',
            'THX Spatial Audio, Bluetooth 5.2',
            '(WxDxH, inch) 19.5 x 11 x 22, 50Hz - 20kHz',
            'CAT6 80mbps',
            '30W adative charging',
            '65Watts',
            'Sheep skin with handmade process',
            '1000 MB/s with low latency'
        ];

        $title = ['Gaming Laptop', 'Gaming PC', 'Office PC', 'Computer Component', 'Display Monitor', 'Gears', 'Music and Sound', 'Accessory'];


        for ($i = 0; $i <= 7; $i++) {
            $category = new Category;
            $category->setTitle($title[$i]);
            $manager->persist($category);
        }

        // Gaming laptop
        for ($i = 0; $i < 5; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);

            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(20000000, 50000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);

            $manager->persist($product);
        }

        // Gaming PC
        for ($i = 5; $i < 10; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);

            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(25000000, 80000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);

            $manager->persist($product);
        }

        // Office PC
        for ($i = 10; $i < 15; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);

            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(4000000, 13000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);

            $manager->persist($product);
        }


        // PC Component
        for ($i = 15; $i < 20; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);
            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(10000000, 20000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);
            $manager->persist($product);
        }

        // Display monitor
        for ($i = 20; $i < 25; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);
            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(10000000, 100000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);
            $manager->persist($product);
        }

        // Gears
        for ($i = 25; $i < 30; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);
            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(1000000, 9000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);
            $manager->persist($product);
        }

        // Music and Sound
        for ($i = 30; $i < 35; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);
            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(4000000, 10000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);
            $manager->persist($product);
        }

        // Accessory
        for ($i = 35; $i < 40; $i++) {
            $random_warranty = array_rand($warranty, 1);
            $random_gift = array_rand($gift, 1);
            $product = new Product;

            $product->setCategory($category)
                ->setName($name[$i])
                ->setPrice(rand(100000, 1000000))
                ->setStock(rand(0, 100))
                ->setImage($image[$i])
                ->setWarranty($warranty[$random_warranty])
                ->setGift($gift[$random_gift])
                ->setModel($model[$i]);
            $manager->persist($product);
        }


        $manager->flush();
    }
}