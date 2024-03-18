<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CurrencyRate;
use Doctrine\ORM\EntityRepository;

class CurrencyRateRepository extends EntityRepository
{
    /**
     * Find a single currency rate by currency name and base currency.
     *
     * @param string $bankName
     * @param string $currency
     * @param string $currencyBase
     *
     * @return CurrencyRate|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastOne(string $bankName, string $currency, string $currencyBase): ?CurrencyRate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.bankName = :bankName')
            ->andWhere('c.currency = :currency')
            ->andWhere('c.currencyBase = :currencyBase')
            ->setParameter('bankName', $bankName)
            ->setParameter('currency', $currency)
            ->setParameter('currencyBase', $currencyBase)
            ->orderBy('c.created', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Save CurrencyRate entity
     *
     * @param CurrencyRate $currencyRate
     */
    public function save(CurrencyRate $currencyRate): void
    {
        $this->_em->persist($currencyRate);
        $this->_em->flush();
    }
}
