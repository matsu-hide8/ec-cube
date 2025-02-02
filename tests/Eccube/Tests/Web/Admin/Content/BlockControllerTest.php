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


namespace Eccube\Tests\Web\Admin\Content;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;

class BlockControllerTest extends AbstractAdminWebTestCase
{

    public function test_routeing_AdminContentBlock_index()
    {

        $this->client->request('GET', $this->app['url_generator']->generate('admin_content_block'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function test_routeing_AdminContentBlock_edit()
    {
        // TODO: テンプレートファイルの参照等がconstant.yml.distで定まらずCIで落ちるためスキップ
        self::markTestSkipped();

        $this->client->request('GET',
            $this->app['url_generator']
                ->generate('admin_content_block_edit',
                    array('block_id' => 1)));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function test_routeing_AdminContentBlock_editWithDevice()
    {
        // TODO: テンプレートファイルの参照等がconstant.yml.distで定まらずCIで落ちるためスキップ
        self::markTestSkipped();

        $this->client->request('GET',
            $this->app['url_generator']
                ->generate('admin_content_block_edit_withDevice',
                    array('page_id' => 1, 'device_type_id' => 10)));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function test_routeing_AdminContentBlock_delete()
    {

        $redirectUrl = $this->app['url_generator']->generate('admin_content_block');

        $this->client->request('GET',
            $this->app['url_generator']
                ->generate('admin_content_block_delete',
                    array('block_id' => 1)));

        $actual = $this->client->getResponse()->isRedirect($redirectUrl);

        $this->assertSame(true, $actual);
    }

    public function test_routeing_AdminContentBlock_deleteWithDevice()
    {

        $redirectUrl = $this->app['url_generator']->generate('admin_content_block');

        $this->client->request('GET',
            $this->app['url_generator']
                ->generate('admin_content_block_delete_withDevice',
                    array('block_id' => 1, 'device_type_id' => 10)));

        $actual = $this->client->getResponse()->isRedirect($redirectUrl);

        $this->assertSame(true, $actual);
    }
}
