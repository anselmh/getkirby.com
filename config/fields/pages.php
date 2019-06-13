<?php

use Kirby\Toolkit\A;
use Kirby\Toolkit\I18n;

return [
    'mixins' => ['min', 'picker'],
    'props' => [
        /**
         * Unset inherited props
         */
        'after'       => null,
        'autofocus'   => null,
        'before'      => null,
        'icon'        => null,
        'placeholder' => null,

        /**
         * Default selected page(s) when a new page/file/user is created
         */
        'default' => function ($default = null) {
            return $this->toPages($default);
        },

        /**
         * Image settings for each item
         */
        'image' => function (array $image = null) {
            return $image ?? [];
        },

        /**
         * Info text for each item
         */
        'info' => function (string $info = null) {
            return $info;
        },

        /**
         * Changes the layout of the selected files. Available layouts: `list`, `cards`
         */
        'layout' => function (string $layout = 'list') {
            return $layout;
        },

        /**
         * Optional query to select a specific set of pages
         */
        'query' => function (string $query = null) {
            return $query;
        },

        /**
         * Layout size for cards: `tiny`, `small`, `medium`, `large` or `huge`
         */
        'size' => function (string $size = 'auto') {
            return $size;
        },

        /**
         * Main text for each item
         */
        'text' => function (string $text = null) {
            return $text;
        },

        'value' => function ($value = null) {
            return $this->toPages($value);
        },
    ],
    'methods' => [
        'pageResponse' => function ($page) {
            return $page->panelPickerData([
                'image' => $this->image,
                'info'  => $this->info,
                'text'  => $this->text,
            ]);
        },
        'toPages' => function ($value = null) {
            $pages = [];
            $kirby = kirby();

            foreach (Yaml::decode($value) as $id) {
                if (is_array($id) === true) {
                    $id = $id['id'] ?? null;
                }

                if ($id !== null && ($page = $kirby->page($id))) {
                    $pages[] = $this->pageResponse($page);
                }
            }

            return $pages;
        }
    ],
    'api' => function () {
        return [
            [
                'pattern' => '/',
                'action' => function () {
                    $field = $this->field();
                    $query = $field->query();

                    if ($query) {
                        $pages = $field->model()->query($query, 'Kirby\Cms\Pages');
                        $model = null;
                    } else {
                        if (!$parent = $this->site()->find($this->requestQuery('parent'))) {
                            $parent = $this->site();
                        }

                        $pages = $parent->children();
                        $model = [
                            'id'     => $parent->id() == '' ? null : $parent->id(),
                            'title'  => $parent->title()->value(),
                            'parent' => $parent->parent() ? $parent->parent()->id() : null,
                        ];
                    }

                    $children = [];

                    foreach ($pages as $index => $page) {
                        if ($page->isReadable() === true) {
                            $children[] = $field->pageResponse($page);
                        }
                    }

                    return [
                        'model' => $model,
                        'pages' => $children
                    ];
                }
            ]
        ];
    },
    'save' => function ($value = null) {
        return A::pluck($value, 'id');
    },
    'validations' => [
        'max',
        'min'
    ]
];