<?php
class TagLibSomnus extends TagLib{
	
	protected $tags = array(
		// attr 属性列表close 是否闭合（0 或者1 默认为1，表示闭合）
        'sitecfg'   => array(
            'attr'  => 'name',
            'close' => 0
        ),
        'block'		=> array(
			'attr'	=> 'name',
			'close'	=> 0
		),
	);


    public function _sitecfg($attr){
        $attr = $this->parseXmlAttr($attr,'sitecfg');
        $name = empty($attr['name']) ? 'sitetitle' : $attr['name'];
        $str = <<<str
<?php
        \$name = "cfg_$name";
        if(empty(\$name)){
            echo "";
        }else{
            echo htmlspecialchars_decode(C(\$name));
        }
?>
str;
        return $str;
    }
	
	
	public function _block($attr){
		$attr = $this->parseXmlAttr($attr,'block');
		$name = empty($attr['name']) ? '' : $attr['name'];
        $str = <<<str
<?php
		\$name = "$name";
		\$Block = D("block");
		\$blockinfo = \$Block->where(array('name' => \$name))->find();
        if(empty(\$blockinfo)){
            echo "";
        }else{
            echo \$blockinfo['cont'];
        }
?>
str;
        return $str;
	}

	
}