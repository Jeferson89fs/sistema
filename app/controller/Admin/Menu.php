<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Menu
{

    private static $modules = [
        'cadastro' => [
            'link' => 'admin/cadastro',
            'label' => 'Cadastro Geral',
            'dropdown' => [
                'localizacao' => [
                    'link' => 'admin/pais',
                    'label' => 'Localização'
                ],
                'clientes' => [
                    'link' => 'admin/clientes',
                    'label' => 'Clientes'
                ],
                'usuarios' => [
                    'link' => 'admin/usuarios',
                    'label' => 'Usuários'
                ]
            ]
        ],
        'depoimento' => [
            'link' => 'admin/depoimento',
            'label' => 'Depoimentos'
        ]


    ];


    public static function getMenuAdmin($current)
    {
        $links = '';

        foreach (self::$modules as $module => $menu) {

            if (is_array($menu['dropdown']) && count($menu['dropdown'])) {

                $dropdownItem = '';
                foreach ($menu['dropdown'] as $modulox => $menux) {

                    $dropdownItem .=  View::render(
                        'Admin/Menu/linkDropDownItem',
                        [
                            'link' => $menux['link'],
                            'label' => $menux['label'],
                            'current' => ($current == $module ? 'text-danger' : ''),
                        ],
                        false
                    );
                }

                $links .= View::render(
                    'Admin/Menu/linkDropDown',
                    [
                        'link' => $menu['link'],
                        'label' => $menu['label'],
                        'current' => ($current == $module ? 'text-danger' : ''),
                        'dropdownItem' => $dropdownItem,
                        'countDropdownItem' => count($menu['dropdown'])
                    ],
                    false
                );
            } else {

                $links .= View::render(
                    'Admin/Menu/link',
                    [
                        'link' => $menu['link'],
                        'label' => $menu['label'],
                        'current' => ($current == $module ? 'text-danger' : '')
                    ],
                    false
                );
            }
        }

        return $links;
    }
}
