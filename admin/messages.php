<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="container-admin">
   <?php include '../components/left-menu.php'; ?>

   <section class="contacts">

      <h1 class="heading"><i class="fas fa-envelope-open-text"></i> Customer Messages & Inquiries</h1>

      <div class="box-container">

         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages` ORDER BY id DESC");
            $select_messages->execute();
            if($select_messages->rowCount() > 0){
               while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="box">
            <p><i class="fas fa-user"></i> Name : <span><?= htmlspecialchars($fetch_message['name']); ?></span></p>
            <p><i class="fas fa-envelope"></i> Email : <span><?= htmlspecialchars($fetch_message['email']); ?></span></p>
            <p><i class="fas fa-phone"></i> Phone : <span><?= htmlspecialchars($fetch_message['number']); ?></span></p>
            <p><i class="fas fa-id-badge"></i> User ID : <span><?= $fetch_message['user_id']; ?></span></p>
            <div style="background: var(--bg-page); padding: 1.2rem; border-radius: var(--radius-md); margin: 1.2rem 0; border: 1px solid var(--border-color);">
               <strong style="display: block; font-size: 1.25rem; color: var(--text-muted); margin-bottom: 0.4rem; text-transform: uppercase;">Inquiry Message:</strong>
               <p style="font-size: 1.45rem; color: var(--text-main); margin: 0; line-height: 1.6;"><?= nl2br(htmlspecialchars($fetch_message['message'])); ?></p>
            </div>
            <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Delete this customer inquiry?');" class="delete-btn"><i class="fas fa-trash-can"></i> Delete Message</a>
         </div>
         <?php
               }
            }else{
               echo '<p class="empty"><i class="fas fa-inbox"></i> You have no messages in your inbox.</p>';
            }
         ?>

      </div>

   </section>

</div>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>
   
</body>
</html>