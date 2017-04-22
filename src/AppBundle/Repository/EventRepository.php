<?php

namespace AppBundle\Repository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllDistinctLieu()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT DISTINCT e.lieu FROM AppBundle:Event e WHERE e.lieu IS NOT NULL'
            )
            ->getResult();
    }

    public function findAllRecent()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM AppBundle:Event e WHERE e.date > CURRENT_DATE() ORDER BY e.datePublication DESC'
            )
            ->getResult();
    }

    public function findAllRecherche($motcle = null, $lieux = null, $categories = null)
    {
        $query = "SELECT e FROM AppBundle:Event e WHERE e.date > CURRENT_DATE()";

        if (isset($motcle) || count($lieux) != 0 || isset($categories)) {
            $query .= " AND (";

            if (isset($motcle)) {
                $query .= "e.nom LIKE '%" . $motcle . "%' OR e.description LIKE '%" . $motcle . "%' ";
            }

            if (count($lieux) != 0) {
                if (strlen($query) > 70) {
                    $query .= "OR ";
                }
                $query .= "e.lieu IN (:lieux) ";
            }

            if (isset($categories)) {
                if (strlen($query) > 70) {
                    $query .= "OR ";
                }
                $index = 0;
                foreach ($categories as $value) {
                    $query .= ":p" . $index . " MEMBER OF e.categories OR ";
                    $index++;
                }
                $query = substr($query, 0, -3);
            }

            $query .= ")";
            var_dump($query);
        }

        $resultat = $this->getEntityManager()
            ->createQuery($query);

            if (count($lieux) != 0){
                $resultat = $resultat->setParameter("lieux", $lieux);
            }

            if (isset($categories)) {
                $index = 0;
                foreach ($categories as $value) {
                    $resultat = $resultat->setParameter("p".strval($index), $value);
                    $index++;
                }
            }

            return $resultat->getResult();
    }
}
