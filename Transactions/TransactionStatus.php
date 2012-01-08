<?php
/**
 * SimpleThings TransactionalBundle
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\TransactionalBundle\Transactions;

/**
 * Contains information about the current state of a transaction.
 */
interface TransactionStatus
{
    /**
     * Checks if the transaction is read-only.
     *
     * A read-only transaction does not commit changes to the database when
     * commit is called. It allows the underlying transaction manager to
     * perform optimizations to this regard if possible.
     *
     * @return bool
     */
    function isReadOnly();

    /**
     * Check if transaction is broken and has to be rolled back at this point.
     *
     * @return bool
     */
    function isRollBackOnly();

    /**
     * Mark the transaction as rollback-only
     *
     * @return void
     */
    function setRollBackOnly();

    /**
     * Check if this transaction was committed already.
     *
     * @return bool
     */
    function isCompleted();

    /**
     * Check if this transaction has savepoints.
     *
     * @return bool
     */
    function hasSavepoint();

    /**
     * Commit the transaction at this point.
     *
     * @return void
     */
    function commit();
}
