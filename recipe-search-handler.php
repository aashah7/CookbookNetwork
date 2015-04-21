<?php
function titleSearch()
{
	$conn = getConn() ;
	
	$title = clean($_POST["title"]);
	$sql = "SELECT * FROM recipe WHERE recipe_title ='$title'";
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}
function ingredientSearch()
{
	$conn = getConn() ;
	$ingredients = array_filter($_POST["ingredient"]);
	$len = count($ingredients);
	
	if($len <= 1)
	{
		$ing = clean($ingredients[0]);
		$sql = " SELECT * FROM recipe 
					WHERE recipe_id in (
						SELECT recipe_id FROM ingredient 
						WHERE name='$ing' )";		
	}
	else
	{
		$first = clean($ingredients[0]) ; 
		$sql = " SELECT recipe_id FROM ingredient
					WHERE name='$first'";
		
		for($i = 1 ; $i < $len ; $i++ )
		{
			$current = clean($ingredients[$i]) ;
			$sql = " SELECT recipe_id FROM ingredient
						WHERE name = '$current' 
							AND recipe_id in (".$sql.")";
		}
		
		$sql = " SELECT * FROM recipe 
					WHERE recipe_id in (".$sql.")";
	}
	
	printResult( $conn -> query($sql) ) ;
	
	$conn -> close() ;
}

function tagBrowse()
{
	$conn = getConn() ;
	
	$tags = $_POST["tags"] ;
	$len = count($tags) ;
	
	if($len <= 1)
	{
		$tag = $tags[0] ;
		$sql = " SELECT * FROM recipe
					WHERE recipe_id in (
						SELECT type_id FROM tag
						WHERE name = '$tag' AND type = 'RECIPE')";
						
	}
	else
	{
		$first = $tags[0] ; 
		$sql = " SELECT type_id FROM tag
					WHERE name = '$first AND type = 'RECIPE'";

		for($i = 1 ; $i < $len ; $i++)
		{
			$current = $tags[$i] ;
			$sql = " SELECT type_id FROM tag
						WHERE name = '$current' 
							AND type = 'RECIPE'
							AND type_id in (".$sql.")" ;
		}		
		
		$sql = " SELECT * FROM recipe
					WHERE recipe_id in (".$sql.")";
	}
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}
function getConn()
{	
	$servername = "localhost";
	$username = "root" ;
	$password = "";
	$dbname = "cookbooknetwork";
	
	return new mysqli($servername, $username, $password, $dbname);
}

function printResult($result)
{
	$rowNum = $result -> num_rows ;
	
	echo '<h1>'.$rowNum.' recipes were found:</h1>' ;
	
	while($rowNum > 0)
	{
		echo'<div class="recipe-preview-row">';
		for($i = 0 ; $i < 3 ; $i++ )
		{
			if($row = $result -> fetch_assoc() )
			{
			    if(isVisible($row["recipe_id"]))
				{
					echo '<a href="view-recipe.php?recipe_id='.$row["recipe_id"].'">
								<div class="recipe-preview-row-icon">
									<img class="thumbnail" src="'.$row["img_path"].'">
									<p>'.$row["recipe_title"].'</p>
								</div>
							</a>';
				}
			}
			$rowNum = $rowNum - 1 ;	
		}
		echo'</div>';
	}
}

function isVisible($recipe_id)
{
	$visibility = getVisibility($recipe_id) ;
	
	if($visibility == 'PRIVATE' ) 
		return isAuthor($recipe_id) ;
	else if($visibility == 'PUBLIC')
		return true ;
	else if($visibility == 'REGISTERED')
		return isset($_SESSION["loggedin"]) and $_SESSION["loggedin"] ;
	else if($visibility == 'FRIENDLY')
		return isFriend($recipe_id) ;
}

function getVisibility($recipe_id)
{
	$conn = getConn() ;
	$sql = "SELECT visibility FROM recipe WHERE recipe_id = '$recipe_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc();
	return $row["visibility"];
}
function isAuthor($recipe_id)
{	
	$conn = getConn() ;
	$sql = " SELECT author FROM recipe
				WHERE recipe_id = '$recipe_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc() ;
	
	return $_SESSION["userid"] == $row["author"] ; 	
}
function isFriend($recipe_id)
{
	$conn = getConn() ;
	$userid = $_SESSION["userid"] ;
	$sql = " SELECT * FROM account
				WHERE user_id = '$userid'
					AND email in (
						SELECT email FROM friends 
						WHERE type = 'RECIPE' 
							AND type_id = '$recipe_id')" ;
	$result = $conn -> query($sql) ;
	return $result -> num_rows > 0 ;
}

function clean($data)
{
	$data = trim($data) ;
	$data = stripslashes($data) ;
	$data = htmlspecialchars($data) ;
	
	return $data ;
}
?>