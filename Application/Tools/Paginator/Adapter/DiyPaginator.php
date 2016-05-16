<?php
namespace MShop\Tools\Paginator\Adapter;
class DiyPaginator {

	public $count = 0;
	public $totalPages = 0;
	public $current = 1;
	public $limit   = 10;
	public $before    = 1;
	public $next    = null;
	public $first   = 1;
	public $last    = null;
	public $afterGroup = null;
	public $beforGroup = null;
	public $codeLength = 10;
	public $diyCode = array();
	public $baiduCode = array();
	public $offset = 0;

	/**
	 * 初始化
	 */
	public function __construct(array $array)
	{
		$this->count = $array['count'];
		$this->current = $array['page'];
		$this->limit = $array['limit'];
		$this->run();
	}

	public function run()
	{
            
		$this->runTotalPages();
                $this->runOffset();
		$this->runFirst();
		$this->runLast();
		$this->runBfore();
		$this->runNext();
		$this->diyCode = $this->getPageCode();
		$this->baiduCode = $this->getBaiduPageCode();
		
	}

	/**
	 * 总页数
	 */
	public function runTotalPages()
	{
		$this->totalPages = ceil($this->count / $this->limit);
	}

	/**
	 * 首页
	 */
	public function runFirst()
	{
		$this->first = 1;
	}

	/**
	 * 尾页
	 */
	public function runLast()
	{
		$this->last = $this->totalPages;
	}

	/**
	 * 上一页
	 */
	public function runBfore()
	{
		if ($this->current > 1) {
			$this->before = $this->current - 1;
		}
	}

	/**
	 * 下一页
	 */
	public function runNext()
	{
		if ($this->current < $this->totalPages) {
			$this->next = $this->current + 1;
		} else if($this->current == $this->totalPages) {
			$this->next = $this->current;
		}
	}

	/**
	 * 计算偏移
	 */
	public function runOffset()
	{
            if ($this->current >= $this->totalPages && $this->totalPages != 0) {
                $this->current = $this->totalPages;
            } else if ($this->current < 1) {
                $this->current = 1;
            } 
            $this->offset = ($this->current - 1) * $this->limit;
        }

	/**
	 * 获取自定义的code页码 默认
	 */
	public function getPageCode($codeLength = 10)
	{
		$current   = $this->current;//当前页面
		$totalpage = $this->totalPages; //总页数

        //起始页码
        if ($current % $codeLength == 0){
            $startCode = floor($current / $codeLength - 1) * $codeLength + 1;
        } else {
            $startCode = floor($current / $codeLength) * $codeLength + 1;
        }

        //结束页码
        $endCode = $startCode + $codeLength -1;

        //计算翻页分组 一次性往前翻页$codeLength条
        if( $current > $codeLength){
        	if ($current % $codeLength == 0) {
            	$this->beforGroup = $current - $codeLength;
        	} else {
        		$this->beforGroup = $current - $codeLength;
        	}
        }

        //计算翻页分组 性往后翻页 
        if ($current <= $codeLength){
            if($totalpage > $codeLength) {
                $this->afterGroup = $codeLength + 1;
            }
        }

        //计算分组翻页 往后翻页
        if ($current > $codeLength){
            if (($totalpage - $startCode) >= ($codeLength - 1)) {
                if ($current % $codeLength == 0) {
                    $this->afterGroup = floor($current / $codeLength) * $codeLength + 1;   
                } else {
                    $this->afterGroup = floor($current / $codeLength) * $codeLength + $codeLength + 1;   
                }
                
            }
        }

        //空数组存放分页码
        $myStylePagecode = array();
        //循环分页码
        for ($i = $startCode; $i <= $endCode; $i++) {
        	if($i > $totalpage) {
        		break;
        	}
            $myStylePagecode[] = $i;
        }

        return $myStylePagecode;
	}

	public function getBaiduPageCode($codeLength = 10)
    {
    	$nowpage   = $this->current;
		$pagenum   = $this->limit;
		$totalpage = $this->totalPages;

		//计算中间页码
		if ($codeLength % 2 == 1) {
			$centerCode = ceil($codeLength / 2);   //奇数
			$leftCodeNum = $codeLength - $centerCode; //左边默认页码
			$rightCodeNum = $leftCodeNum ; //右边默认页码数量
		} else {
			$centerCode = $codeLength / 2 + 1; //偶数
			$leftCodeNum = $codeLength - $centerCode + 1; //左边默认页码
			$rightCodeNum = $leftCodeNum - 1; //右边默认页码数量
		}

		if ($nowpage >= $centerCode) {
			$startCode = $nowpage - $leftCodeNum ;
			$endCode = $nowpage + $rightCodeNum;
			if ($endCode >= $totalpage) {
				$endCode = $totalpage;
				if ($endCode <= $codeLength) {
					$startCode = 1;
				}
			} 
		} else {
			$startCode = 1;
			$endCode = $codeLength;
			if($endCode > $totalpage) {
				$endCode = $totalpage;
			}
		}

        //定义用于组装分页码的空数组
        $baiduStylePageCode = array();
  
        for ($i =$startCode; $i <= $endCode; $i++){
            //循环组装分页码
            $baiduStylePageCode[] = $i;
        }
        //返回组装的分页码
        return $baiduStylePageCode;
    }

}