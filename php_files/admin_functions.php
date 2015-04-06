<?php
//signup.php
include 'connect.php';
include 'header.php';


?>


									   <?php if (@$_GET['value']==1): ?>
                                       <form method="post" action="operations.php?method=1">

                                        <p>UPDATE A USER </p>
                                        <select name="role">

                                         <option value="1">Admin</option>
                                         <option value="2">Moderator</option>
                                         <option value="3">User</option>

                                       </select >


                                       <?php

                                       require ('config.php');

//connect to MySQL
                                       $mysqli = new mysqli (SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or 
                                       die ("Check your server connection.");


                                       $query = "SELECT username from user_credentials";

                                       $results = $mysqli->query($query)
                                       or die($mysqli->error);

                                       echo "CATEGORY ID:";
                                       echo "<select name='name'>";
                                       while ($row = $results->fetch_assoc())
                                        echo "<option value='{$row['username']}'>{$row['username']}</option>";
                                      echo '</select>';

                                      $mysqli->close();


                                      ?>



                                      <button name="Submit" value="Submit" >Update</button>
                                    </form>

                                  <?php endif;if (@$_GET['value']==2): ?>

                                  <form method="post" action="operations.php?method=2">
                                   <p> CREATE A NEW SUB-CATEGORY</p>
                                   <select name="category">
                                     <option value="1">hardware</option>
                                     <option value="2">software</option>
                                   </select>

                                   <input type="text" placeholder="New Sub Category"  name="subcat" required>

                                   <button name="Submit" value="Submit" class="btn btn-success">Create</button>
                                 </form>

                               <?php endif; if (@$_GET['value']==3): ?>


                               <form method="post" action="operations.php?method=3">

                                <p>UPDATE A SUB-CATEGORY </p>
                                <select name="id">

                                 <option value="1">hardware</option>
                                 <option value="2">software</option>

                               </select >


                               <?php

                               require ('config.php');

//connect to MySQL
                               $mysqli = new mysqli (SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or 
                               die ("Check your server connection.");


                               $query = "SELECT name from forum_subcategory";

                               $results = $mysqli->query($query)
                               or die($mysqli->error);

                               echo "CATEGORY ID:";
                               echo "<select name='category'>";
                               while ($row = $results->fetch_assoc())
                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                              echo '</select>';

                              $mysqli->close();


                              ?>



                              <button name="Submit" value="Submit" >Update</button>
                            </form>

                          <?php endif; if (@$_GET['value']==4): ?>
                          <form method="post" action="operations.php?method=4">

                            <?php

                            require ('config.php');

//connect to MySQL
                            $mysqli = new mysqli (SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or 
                            die ("Check your server connection.");


                            $query = "SELECT name from forum_subcategory";

                            $results = $mysqli->query($query)
                            or die($mysqli->error);

                            echo "CATEGORY ID:";
                            echo "<select name='category'>";
                            while ($row = $results->fetch_assoc())
                              echo "<option value='{$row['name']}'>{$row['name']}</option>";
                            echo '</select>';

                            $mysqli->close();


                            ?>




                            <button name="Submit" value="Submit" class="btn btn-success">Delete</button>
                          </form>
                        <?php endif; ?>




<?php
include 'footer.php';
?>
