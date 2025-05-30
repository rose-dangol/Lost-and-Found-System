<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - LostLinkers</title>
  <style>
   .contact-form-section {
  padding: 2rem;
  background-color: #f9fafc;
  border-radius: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 2rem;
}

.contact-form-section h2 {
  font-size: 1.75rem;
  margin-bottom: 1rem;
  color: #333;
}

.contact-form-section p {
  font-size: 1rem;
  color: #555;
  margin-bottom: 1rem;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 1rem;
}

.contact-form input,
.contact-form textarea {
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  font-size: 1rem;
  width: 100%;
  transition: border-color 0.3s ease;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-color: #007bff;
  outline: none;
}

.btn.submit-btn {
  padding: 0.75rem 1.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
  align-self: flex-start;
}

.btn.submit-btn:hover {
  background-color: #0056b3;
}
</style> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
  <div class="container">


    <main class="main-content">
      <header class="topbar">
        <div class="logo">LostLinkers - Lost & Found</div>
                <div class="icons">
          <i class="fa fa-search"></i>
          <i class="fa fa-bars"></i>
          <i class="fa fa-user"></i>
        </div>
      </header>

      <section class="contact-section">
        <h2>Contact Us</h2>
        <p>We're here to help. Feel free to reach out with any questions, concerns, or suggestions.</p>

        <form action="#" method="post" class="contact-form">
          <input type="text" name="name" placeholder="Your Name" required />
          <input type="email" name="email" placeholder="Your Email" required />
          <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
          <button type="submit" class="btn submit-btn">Send Message</button>
        </form>

        <p>You can also email us directly at <a href="mailto:support@lostlinkers.com">support@lostlinkers.com</a></p>
      </section>
    </main>
  </div>
</body>
</html>
