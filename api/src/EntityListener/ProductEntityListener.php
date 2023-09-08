<?php

namespace App\EntityListener;

use App\Entity\Product;
use DateTime;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductEntityListener
{
    /**
     * @param Product $product
     * @param PostPersistEventArgs $eventArgs
     * @return void
     */
    public function postPersist(Product $product, PostPersistEventArgs $eventArgs)
    {
//        $test = $this->getObjectManager()->getUnitOfWork()->getEntityChangeSet($eventArgs->getObject());
    }

    /**
     * @param Product $product
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function postUpdate(Product $product, LifecycleEventArgs $eventArgs): void
    {
        $test = 1;
    }

    /**
     * @param Product $product
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function preUpdate(Product $product, LifecycleEventArgs $eventArgs): void
    {
        $test = 1;
    }

    /**
     * @param Product $product
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(Product $product, LifecycleEventArgs $eventArgs): void
    {
        $newName = $product->getName() . " 1";

//        $time = $product->getAddTime();
//        $convertTimeToBigint = strtotime($time);

//        $test = date('Y-m-d H:i:s',$convertTimeToBigint);

        date_default_timezone_set('Europe/Kiev');
        $date = new DateTime();
        $convertTimeToBigint = strtotime($date->format("YmdHis"));

        $product->setAddTime($convertTimeToBigint);
        $product->setName($newName);
    }
}