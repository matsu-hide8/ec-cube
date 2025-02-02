<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Controller\Admin\Basis;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class BasisController extends AbstractController
{
    private $main_title;
    private $sub_title;

    public $form;

    public function __construct()
    {
        $this->main_title = '基本情報管理';
        $this->sub_title = 'SHOPマスター';

        $this->tpl_subno = 'index';
        $this->tpl_mainno = 'basis';
    }

    public function index(Application $app)
    {
        $BaseInfo = $app['eccube.repository.base_info']->get();
        // FIXME: ArrayにしたりStringにしたり, booleanにしたりやめたい
        $BaseInfo->setRegularHolidayIds(explode('|', $BaseInfo->getRegularHolidayIds()));
        $BaseInfo->setDownloadableDaysUnlimited($BaseInfo->getDownloadableDaysUnlimited() == 1 ? true : false);

        $form = $app['form.factory']
            ->createBuilder('shop_master', $BaseInfo)
            ->getForm();

        if ($app['request']->getMethod() === 'POST') {
            $form->handleRequest($app['request']);
            if ($form->isValid()) {
                // FIXME: ArrayにしたりStringにしたり, booleanにしたりやめたい
                $BaseInfo->setRegularHolidayIds(implode('|', $BaseInfo->getRegularHolidayIds()));
                $app['orm.em']->persist($BaseInfo);
                $app['orm.em']->flush();
                $app['session']->getFlashBag()->add('shop_master.complete', 'admin.register.complete');

                return $app->redirect($app['url_generator']->generate('admin_basis'));
            }
        }

        return $app['twig']->render('Admin/Basis/shop_master.twig', array(
            'tpl_maintitle' => $this->main_title,
            'tpl_subtitle' => $this->sub_title,
            'form' => $form->createView(),
        ));
    }
}
