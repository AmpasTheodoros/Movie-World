<?php 
// Pointer gia na bri to path
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");


$posts = array();
$postsTitle = 'Recent Posts';

if (isset($_GET['t_id'])) {
  $posts = getPostsByTopicId($_GET['t_id']);
  $postsTitle = "You searched for posts under '" . $_GET['name'] . "'";
} else if (isset($_POST['search-term'])) {
  $postsTitle = "You searched for '" . $_POST['search-term'] . "'";
  $posts = searchPosts($_POST['search-term']);
} else {
  $posts = getPublishedPosts();
}
/////////////////////////////////// LIKE AND DISLIKE ////////////////////////////////////////////////
if (isset($_SESSION['id'])):
{
    $user_id = $_SESSION['id'];
}else:
  $user_id = 1;
endif;
// An o user patisi like i dislike
if (isset($_POST['action'])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  if ($user_id != 1)
  {
    switch ($action) {
      case 'like':
          $sql="INSERT INTO rating_info (user_id, post_id, rating_action) VALUES ($user_id, $post_id, 'like') ON DUPLICATE KEY UPDATE rating_action='like'";
          break;
      case 'dislike':
            $sql="INSERT INTO rating_info (user_id, post_id, rating_action) VALUES ($user_id, $post_id, 'dislike') ON DUPLICATE KEY UPDATE rating_action='dislike'";
          break;
      case 'unlike':
          $sql="DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
          break;
      case 'undislike':
            $sql="DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
        break;
      default:
        break;
    }

  }

  mysqli_query($conn, $sql);
  echo getRating($post_id);
  exit(0);
}

// Sinoliko arithmo likes apo kathe post
function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Sinoliko arithmo dislikes apo kathe post
function getDislikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='dislike'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Sinoliko arithmo apo dislikes kai likes apo kathe post
function getRating($id)
{
  global $conn;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'";
  $dislikes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='dislike'";
  $likes_rs = mysqli_query($conn, $likes_query);
  $dislikes_rs = mysqli_query($conn, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

//elegxi an exis kani idi like to post i oxi
function userLiked($post_id)
{
  global $conn;
  global $user_id;
  $sql = "SELECT * FROM rating_info WHERE user_id=$user_id 
  		  AND post_id=$post_id AND rating_action='like'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

//elegxi an exis kani idi dislike to post i oxi
function userDisliked($post_id)
{
  global $conn;
  global $user_id;
  $sql = "SELECT * FROM rating_info WHERE user_id=$user_id 
  		  AND post_id=$post_id AND rating_action='dislike'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

$sql = "SELECT * FROM posts";
$results = mysqli_query($conn, $sql);
$post = mysqli_fetch_all($results, MYSQLI_ASSOC);

/////////////////////////////////////////////////////////// ORDER //////////////////////////////////////////////////////////////
$query = "SELECT * FROM posts ORDER BY id DESC";  
$result = mysqli_query($conn, $query);  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts Candal.ttf kai Lora.ttf -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">
    
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>MovieWorld</title>
</head>

<body>
  <!-- prostheti ton kodika gia na apofigoume to grafoume sinexia -->
  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>


  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider -->
    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">

        <?php foreach ($posts as $post): ?>
          <div class="post">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image">
            <div class="post-info">
              <h4><a id="<?php echo $post['id']; ?>" href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h4>
              <i class="far fa-user"><a href="#"><?php echo $post['username']; ?></a></i> <!-- dokimi -->
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
            </div>
          </div>
        <?php endforeach; ?>


      </div>

    </div>
    <!-- Post Slider -->

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title"><?php echo $postsTitle ?></h1>

        <?php foreach ($posts as $post): ?>
          <div class="post clearfix">
          
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="post-image">
            <div class="post-preview">
              <h2><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
              <i class="far fa-user"><?php echo $post['username']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
              <p class="preview-text">
                <?php echo html_entity_decode(substr($post['body'], 0, 100) . '...'); ?>
              </p>
              <div>
                  <i style="color: blue; font-size: 1.2em;" 
                    <?php if (userLiked($post['id'])): ?>
                      class="fas fa-thumbs-up like-btn"
                    <?php else: ?>
                      class="far fa-thumbs-up like-btn"
                    <?php endif ?>
                    data-id="<?php echo $post['id'] ?>"></i>
                  <span class="likes"><?php echo getLikes($post['id']); ?></span> <!-- sort -->
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!-- not breaking space -->
                  <i style="color: blue; font-size: 1.2em;" 
                    <?php if (userDisliked($post['id'])): ?>
                      class="fas fa-thumbs-down dislike-btn"
                    <?php else: ?>
                      class="far fa-thumbs-down dislike-btn"
                    <?php endif ?>
                    data-id="<?php echo $post['id'] ?>"></i>
                  <span class="dislikes" id="dislikes"><?php echo getDislikes($post['id']); ?></span> <!-- sort -->
                </div>
              <a href="single.php?id=<?php echo $post['id']; ?>" class="btn read-more">Read More</a>
            </div>
          </div>    
        <?php endforeach; ?>
        


      </div>
      <!-- Main Content -->

      <div class="sidebar">
      
        <div class="section search">
          <h2 class="section-title">Search</h2>
          <form action="index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Search...">
          </form>
        </div>


        <div class="section topics">
          <h2 class="section-title">Topics</h2>
          <ul>
            <?php foreach ($topics as $key => $topic): ?>
              <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic['name'] ?>"><?php echo $topic['name']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <a href="<?php echo BASE_URL . '/admin/posts/usersCreate.php'; ?>" class="btn read-more" >Post a Movie</a>

      </div>

    </div>
    <!-- Content -->

    <br />             
      <table class="table-sortable ">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Likes</th>
            <th>Dislikes</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          while($row = mysqli_fetch_array($result))  
          {  
          ?>                       
            <tr>
              <td><?php echo $row["id"]; ?></td>
              <td><?php echo $row["title"]; ?></td>
              <td><?php echo getLikes($row['id']); ?></td>
              <td><?php echo getDislikes($row['id']); ?></td>
              <td><?php echo $row["created_at"]; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <br /> 


  </div>
  <!-- Page Wrapper -->

  <!-- prostheti ton kodika tou footer gia na apofigoume to grafoume sinexia -->
  <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Slick Carousel -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Java Script -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/reaction.js"></script>

</body>

</html>
<script>
  function sortTableByColumn(table, column, asc = true) {
    const dirModifier = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll("tr"));

    // Sort each row
    const sortedRows = rows.sort((a, b) => {
        const aColText = a.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();
        const bColText = b.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    });

    // Remove all existing TRs from the table
    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }

    // Re-add the newly sorted rows
    tBody.append(...sortedRows);

    // Remember how the column is currently sorted
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-asc", asc);
    table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-desc", !asc);
}

document.querySelectorAll(".table-sortable th").forEach(headerCell => {
    headerCell.addEventListener("click", () => {
        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains("th-sort-asc");

        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
    });
});

 </script>  