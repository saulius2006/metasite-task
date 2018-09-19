<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSubscribersListController extends AbstractController
{
    /**
     * @Route("/admin/subscribers-list", name="admin_subscribers_list")
     */
    public function listSubscribers(Request $request)
    {

    	$subscribers = $this->getSubscribers($request->query->get('sort'), $request->query->get('sortorder'));

        return $this->render('admin/subscribers-list.html.twig', [
            'subscribers' => $subscribers,
	        'sort' => $request->query->get('sort'),
	        'sortorder' => $request->query->get('sortorder'),
        ]);
    }

    private function getSubscribers($sort, $sortorder) {
    	$subscribers = json_decode(file_get_contents(getcwd().'/../data/Registrations.json'), true);
		$categories = Category::getCategories();

		foreach ($subscribers as &$subscriber) {
			$sub_cats = [];
			foreach ($subscriber['category'] as $sub_cat) {

				$sub_cats[] = array_search($sub_cat, $categories);
			}
			$subscriber['category'] = implode(', ', $sub_cats);
		}
		if (!empty($sortorder) && !empty($sort) && $sortorder == 'asc') {
			switch ($sort) {
				case 'date':
					usort($subscribers, function ($a, $b) {return $a['created'] < $b['created'] ? -1 : 1;});
					break;
				case 'name':
					usort($subscribers, function ($a, $b) {return strnatcmp($a['name'], $b['name']);});
					break;
				case 'email':
					usort($subscribers, function ($a, $b) {return strnatcmp($a['email'], $b['email']);});
					break;
			}
		} elseif (!empty($sortorder) && !empty($sort) && $sortorder == 'desc') {
			switch ($sort) {
				case 'date':
					usort($subscribers, function ($a, $b) {return $a['created'] > $b['created'] ? -1: 1;});
					break;
				case 'name':
					usort($subscribers, function ($a, $b) {return strnatcmp($b['name'], $a['name']);});
					break;
				case 'email':
					usort($subscribers, function ($a, $b) {return strnatcmp($b['email'], $a['email']);});
					break;
			}

		}


		return $subscribers;
    }
}
