<?php

namespace Network;

class Page
{
	/**
	 * 配置选项
	 * @var unknown
	 */
	protected $option = array();
	
	/**
	 * 构造函数,设置参数
	 * @param int 当前第几页 $current
	 * @param int 总共多少条 $total
	 * @param int 每页多少条 $eachNum
	 * @param int 显示几个按钮 $buttonNum
	 * @param string get请求中表示分页的字段
	 * @param int $key
	 */
	public function __construct($current, $total, $eachNum, $buttonNum, $getKey='page')
	{
		$this->option['current'] = $current;
		$this->option['total'] = $total;
		$this->option['eachNum'] = $eachNum;
		$this->option['buttonNum'] = $buttonNum;
		$this->option['getKey'] = $getKey;
		$this->option['pageCount'] = ceil($total/$eachNum);
	}
	
	/**
	 * 
	 */
	public function build()
	{
		// 设置url地址
		$url = $this->setUrl($key);
		$pageList = self::setRange();
	}
	
	
	
	/**
	 * 执行分页
	 * @param int 当前第几页
	 * @param int 总共多少条
	 * @param int 每页多少条
	 * @param int 可用的按钮有多少个
	 * @param int 分页的key值
	 * @return string 分页的a连接
	 */
	public static function build($now, $total, $each, $limit=10, $key='page')
	{
		// 必要条件
		if($total && $now <= $count)
		{
			
		}
		else
		{
			$now = $count;
		}
		// 分页信息
		$pageList[] = "<span class='page-limit'>{$now}/{$count}页</span>,<span class='page-count'>每页{$each}条/共{$total}条</span>";
		return implode("", $pageList);
	}
	/**
	 * 分页的url地址
	 * @param string 分页key
	 * @return string 分页的url前面部分
	 */
	private static function setUrl($key)
	{
		// 协议
		$build['scheme'] = "http://";
		// 主机
		$build['host'] = F::server('HTTP_HOST');
		// 解析pathinfo和query_string
		$info = parse_url(F::server('REQUEST_URI'));
		// path信息
		$build['path'] = isset($info['path']) ? $info['path'] : NULL;
		// query信息
		$build['query'] = NULL;
		if(isset($info['query']))
		{
			parse_str($info['query'], $query);
			unset($query[$key]);
			$build['query'] = http_build_query($query);
			$build['query'] = $build['query'] ? $build['query'] . '&' : $build['query'];
		}
		// 完整路径
		return "{$build['scheme']}{$build['host']}{$build['path']}?{$build['query']}";
	}
	/**
	 * 设置范围分页
	 * @param int 当前页
	 * @param int $limit 多少个按钮
	 * @param int 总页数
	 * @return string
	 */
	private static function setRange($now, $limit, $count)
	{
		// 首页
		$pageList[] = $now > 1 ? "<a href='{$url}{$key}=1'>首页</a>" : NULL;
		// 上一页
		$pageList[] = $now > 1 ? "<a href='{$url}{$key}=1'>上一页</a>" : NULL;
		// 区间
		list($start, $end) = self::calcLimit($now, $limit, $count);
		// 计算区间
		for(; $start<=$end; $start++)
		{
		$class = ($start == $now) ? 'class="page-selected"' : NULL;
		$pageList[] = "<a {$class} href='{$url}{$key}={$start}'>{$start}</a>";
		}
		// 下一页
		$pageList[] = $now < $count ? "<a href='{$url}{$key}=".($now+1)."'>下一页</a>" : NULL;
		// 末页
		$pageList[] = $now < $count ? "<a href='{$url}{$key}={$count}'>末页</a>" : NULL;
	}
		/**
		* 计算按钮的分页数据
		* @param int 当前第几页
		* @param int 分成几个按钮
		* @param int 总共几页
		* @return array(开始,结束)
		*/
		public function calcLimit($nowPage, $limit, $totalPage)
		{
		// 计算开始按钮
		$start =  $nowPage%$limit == 0 ? $nowPage-$limit+1 : floor($nowPage/$limit)*$limit+1;
		// 终止按钮
		$end =  $start + $limit - 1;
		// 调整结束按钮
		$end = $end >= $totalPage ? $totalPage : $end;
		return array($start, $end);
		}
}