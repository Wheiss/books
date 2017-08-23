<?php

class Paginator
{
    private $_items = NULL;
    private $_ItemsCount = NULL;
    private $_pageSize = NULL;
    private $_pageCount = NULL;
    private $_pages = NULL;
    private $_currentPage = NULL;

    public function generatePages()
    {
        /* 1. Page Count*/
        $this->_pageCount = intval(ceil($this->_ItemsCount));


        $border = 2;

        /* Paginator borders*/
        $rightBorder = $this->_currentPage + $border + 2;
        $leftBorder = $this->_currentPage - $border - 2;

        if ($rightBorder > $this->_pageCount) {
            $rightBorder = $this->_pageCount;
        }
        if ($leftBorder < 1) {
            $leftBorder = 1;
        }
        /* __Paginator borders__ */
        /* _____________________*/

        $urls = array();
        /* Paginator body*/
        $nextUrl = NULL;
        for ($i = $leftBorder; $i <= $rightBorder; $i++) {
            //  This Page
            if ($i == $this->_currentPage) {
                $urls[] = array('current' => $this->_currentPage, 'text' => $i);
                continue;
            }
            //  Right border
            if ($i == $rightBorder) {
                $urls[] = array('link' => Router::url('books',
                    array('PAGE' => $this->_pageCount,
                        'SORT' => (!empty($this->sortName) ? $this->sortName . '-' .  $this->sortAttribute : ''))),
                    'text' => $this->_pageCount);
                break;
            }
            //  Next
            if ($i == ($this->_currentPage + 1)) {
                $nextUrl = array('next' => Router::url('books',
                    array('PAGE' => $i,
                        'SORT' => !empty($this->sortName) ? $this->sortName . '-' .  $this->sortAttribute : '')),
                    'text' => $i);
            }
            //  Previous
            if ($i == ($this->_currentPage - 1)) {
                array_unshift($urls, array('previous' => Router::url('books',
                    array('PAGE' => $i,
                        'SORT' => (!empty($this->sortName) ? $this->sortName . '-' . $this->sortAttribute : ''))),
                    'text' => $i));
            }
            if (($i == 1) || ($i == $leftBorder)) {
                $urls[] = array('link' => Router::url('books',
                    array('PAGE' => 1,
                        'SORT' => (!empty($this->sortName) ? $this->sortName . '-' . $this->sortAttribute : ''))),
                    'text' => 1);
                continue;
            }
            //     ...
            if (($i == $this->_currentPage - $border - 1) || ($i == $this->_currentPage + $border + 1)) {
                $urls[] = array('blank' => '...');
                continue;
            }
            //  Pages
            $urls[] = array('link' => Router::url('books',
                array('PAGE' => $i,
                    'SORT' => (!empty($this->sortName) ? $this->sortName . '-' . $this->sortAttribute : ''))),
                'text' => $i);
        }
        if (isset($nextUrl)) {
            array_push($urls, $nextUrl);
        }
        /* __Paginator body__*/
        /* _________________*/

        /* 2. Pages*/
        $this->_pages = $urls;
    }

    public function setItems($items) {
        $this->_items = $items;
    }

    public function setItemsCount($count)
    {
        $this->_ItemsCount = $count;
    }

    public function setCurrentPage($page)
    {
        $this->_currentPage = $page;
    }

    public function setPageSize($size)
    {
        $this->_pageSize = $size;
    }

    public function getItems()
    {
        return $this->_items;
    }

    public function getPages()
    {
        return $this->_pages;
    }

    public function getCurrentPage()
    {
        return $this->_currentPage;
    }
}