<?php
	$sudoku=array();
	if(isset($_POST['solve']))
	{
		$x=0;
		for($i=0;$i<9;$i++)
		{
			$row=array();
			for($j=0;$j<9;$j++)
			{
				$s='box'.$i.$j;
				$number=$_POST[$s];
				if($number=='')
					$number=0;
				$sudoku[$i][$j]=$number;
			}
		}
		$z=81;
		while($z!=0)
		{
			$z=$z-1;
			$sudoku=rows($sudoku);
			$sudoku=columns($sudoku);
			$sudoku=box($sudoku);
		}
		//print_r($sudoku);
	}
	else
	{
		for($i=0;$i<9;$i++)
		{
			$row=array();
			for($j=0;$j<9;$j++)
			{
				array_push($row,0);
			}
			array_push($sudoku,$row);
		}
	}
	
	function is_in_row($p,$x,$sudoku)
	{
		for($i=0;$i<9;$i++)
		{
			//echo $sudoku[$p][$i];
			if($sudoku[$p][$i]==$x)
				return true;
		}
		return false;
	}
	function is_in_column($p,$x,$sudoku)
	{
		for($i=0;$i<9;$i++)
			if($sudoku[$i][$p]==$x)
				return true;
		return false;
	}
	function is_in_box($p,$x,$sudoku)
	{
		for($i=0;$i<3;$i++)
			for($j=0;$j<3;$j++)
				if($sudoku[(((int)($p/3))*3)+$i][(($p%3)*3)+$j]==$x)
					return true;
		return false;
	}
	
	function rows($sudoku)
	{		
		for($i=0;$i<9;$i++)
		{
			$x=$y=0;
			for($j=0;$j<9;$j++)
			{
				if($sudoku[$i][$j]==0)
				{
					$x++;
				}
				else
				{
					$y=$y+$sudoku[$i][$j];
				}
			}
			if($x==1)
			{
				for($j=0;$j<9;$j++)
				{
					if($sudoku[$i][$j]==0)
					{
						$sudoku[$i][$j]=45-$y;
						//printf("r1: %d %d %d\n",i,j,45-y);
						break;
					}
				}
			}
			else
			{
				for($j=1;$j<=9;$j++)
				{
					if(!is_in_row($i,$j,$sudoku))
					{
						$x=0;
						for($k=0;$k<9;$k++)
						{
							if(!is_in_column($k,$j,$sudoku) && !is_in_box((((int)($i/3))*3)+((int)($k/3)),$j,$sudoku) && $sudoku[$i][$k]==0)
								$x++;
							if($x==2)
								break;
						}
						if($x==1)
						{
							for($k=0;$k<9;$k++)
							{
								if(!is_in_column($k,$j,$sudoku) && !is_in_box((((int)($i/3))*3)+((int)($k/3)),$j,$sudoku) && $sudoku[$i][$k]==0)
								{
									$sudoku[$i][$k]=$j;
									//printf("r2: %d %d %d\n",i,k,j);
									//c++;
									break;
								}
							}
						}
					}
				}
			}
		}
		
		return $sudoku;
	}
	
	function columns($sudoku)
	{
		for($i=0;$i<9;$i++)
		{
			$x=$y=0;
			for($j=0;$j<9;$j++)
			{
				if($sudoku[$j][$i]==0)
				{
					$x++;
				}
				else
				{
					$y+=$sudoku[$j][$i];
				}
			}
			if($x==1)
			{
				for($j=0;$j<9;$j++)
				{
					if($sudoku[$j][$i]==0)
					{
						$sudoku[$j][$i]=45-$y;
						//printf("c1: %d %d %d\n",j,i,45-y);
						break;
					}
				}
			}
			else
			{
				for($j=1;$j<=9;$j++)
				{
					if(!is_in_column($i,$j,$sudoku))
					{
						$x=0;
						for($k=0;$k<9;$k++)
						{
							if(!is_in_row($k,$j,$sudoku) && !is_in_box((((int)($k/3))*3)+((int)($i/3)),$j,$sudoku) && $sudoku[$k][$i]==0)
							{
								$x++;
							}
							if($x==2)
								break;
						}
						if($x==1)
						{
							for($k=0;$k<9;$k++)
							{
								if(!is_in_row($k,$j,$sudoku) && !is_in_box((((int)($k/3))*3)+((int)($i/3)),$j,$sudoku) && $sudoku[$k][$i]==0)
								{
									$sudoku[$k][$i]=$j;
									//printf("c2: %d %d %d\n",k,i,j);
									break;
								}
							}
						}
					}
				}
			}
		}
		
		return $sudoku;
	}
	
	function box($sudoku)
	{
		for($i=0;$i<9;$i++)
		{
			$x=$y=0;
			for($j=0;$j<3;$j++)
			{
				for($k=0;$k<3;$k++)
				{
					if($sudoku[(((int)($i/3))*3)+$j][(($i%3)*3)+$k]==0)
						$x++;
					else
						$y+=$sudoku[(((int)($i/3))*3)+$j][(($i%3)*3)+$k];
				}
			}
			if($x==1)
			{
				for($j=0;$j<3 && $x;$j++)
				{
					for($k=0;$k<3;$k++)
					{
						if($sudoku[(((int)($i/3))*3)+$j][(($i%3)*3)+$k]==0)
						{
							$sudoku[(((int)($i/3))*3)+$j][(($i%3)*3)+$k]=45-$y;
							//printf("b1: %d %d %d\n",((i/3)*3)+j,((i%3)*3)+k,45-y);
							$x--;
							break;
						}
					}
				}
			}
			else
			{
				for($j=1;$j<=9;$j++)
				{
					if(!is_in_box($i,$j,$sudoku))
					{
						$x=0;
						for($k=0;$k<3;$k++)
						{
							for($l=0;$l<3;$l++)
							{
								if(!is_in_column((($i%3)*3)+$l,$j,$sudoku) && !is_in_row((((int)($i/3))*3)+$k,$j,$sudoku) && $sudoku[(((int)($i/3))*3)+$k][(($i%3)*3)+$l]==0)
									$x++;
								if($x==2)
									break;
							}
						}
						if($x==1)
						{
							for($k=0;$k<3 && $x;$k++)
							{
								for($l=0;$l<3;$l++)
								{
									if(!is_in_column((($i%3)*3)+$l,$j,$sudoku) && !is_in_row((((int)($i/3))*3)+$k,$j,$sudoku) && $sudoku[(((int)($i/3))*3)+$k][(($i%3)*3)+$l]==0)
									{
										$sudoku[(((int)($i/3))*3)+$k][(($i%3)*3)+$l]=$j;
										//printf("b2: %d %d %d\n",((i/3)*3)+k,((i%3)*3)+l,j);
										$x--;
										break;
									}
								}
							}
						}
					}
				}
			}
		}
		
		return $sudoku;
	}
?>

<center>
	<div>
		<form method="POST" action="index.php">
			<?php
				for($i=0;$i<9;$i++)
				{
					for($j=0;$j<9;$j++)
					{
						$a=$b=$c=$d='1px';
						if(($i%3)==0)
							$a='5px';
						if(($j%3)==0)
							$b='5px';
						if(($i%3)==2)
							$c='5px';
						if(($j%3)==2)
							$d='5px';
						$s='border-top: '.$a.' solid red;';
						$s.='border-left: '.$b.' solid red;';
						$s.='border-bottom: '.$c.' solid red;';
						$s.='border-right: '.$d.' solid red;';
						if($sudoku[$i][$j]==0)
							$number='';
						else
							$number=$sudoku[$i][$j];
						echo '<textarea rows="1" cols="1" name="box'.$i.$j.'" style="'.$s.' resize:none;font-size:50px;width: 70px;height: 70px;text-align:center">'.$number.'</textarea>';
					}
					echo '<br>';
				}
			?>
			<input type="submit" value="Solve" name=" solve" style="resize:none;font-size:56px;text-align:center">
		</form>
	</div>
</center>