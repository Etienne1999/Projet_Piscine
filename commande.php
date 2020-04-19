<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database/db_connect.php");

    //Redirection vers login si pas d'utilisateur connecté
    if (!isset($_SESSION['user_ID'])) 
    {
        header("Location: login.php");
    }

    if (isset($_SESSION['panier']) && empty($_SESSION['panier'])) {
        header("Location: index.php");
    }

    if (isset($_POST['btn_add_carte'])) {
        $id = $_SESSION['user_ID'];
        $num_carte = isset($_POST["num_carte"])? $_POST["num_carte"] : "";
        $proprietaire = isset($_POST["proprietaire"])? $_POST["proprietaire"] : "";
        $exp_MM = isset($_POST["exp_MM"])? $_POST["exp_MM"] : "";
        $exp_YY = isset($_POST["exp_YY"])? $_POST["exp_YY"] : "";
        $cvv = isset($_POST["cvv"])? $_POST["cvv"] : "";
        $plafond = isset($_POST["plafond"])? $_POST["plafond"] : "";
        $type = isset($_POST["type"])? $_POST["type"] : "";
        $adresse_factu = isset($_POST["adresse_factu"])? $_POST["adresse_factu"] : "";

        //formate la date
        $date_exp = $exp_YY . "-" . $exp_MM . '-01';

        $sql = "INSERT INTO `carte_bancaire` (`Numero_Carte`, `Nom_Proprietaire`, `Date_exp`, `CVV`, `Plafond`, `ID_User`, `Type`, `Adresse_Facturation`) VALUES ('$num_carte', '$proprietaire', '$date_exp', '$cvv', ";
        if (!empty($plafond))
            $sql .= "'$plafond', ";
        else
            $sql .= "NULL, ";
        $sql .= "'$id', '$type', '$adresse_factu')";

        $res = mysqli_query($db_handle, $sql);
        //var_dump($res);
    }

    $montant_total = 0;
    $code_reduc = -1;
    $reduc_restant = -1;
    $code_cadeau = -1;
    $cadeau_restant = 0;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Paiement</title>
    <link rel="stylesheet" href="css/paiement.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Navbar -->
    <?php include("nav.php") ?>
    <?php include("modal/modal_carte_credit.php") ?>

    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Paiement</h2>
                </div>
                <form>
                    <div class="products">
                        <h3 class="title">Détail commande</h3>

                        <?php
                            foreach ($_SESSION['panier'] as $item) {
                                $sql = "SELECT Nom, Prix_Achat, Description FROM produit WHERE ID = '$item'" ;
                                $res = mysqli_query($db_handle, $sql);
                                //var_dump($res);
                                while ($info_item = mysqli_fetch_assoc($res)) {
                                    echo '<div class="item"><span class="price">' . $info_item['Prix_Achat'] . '€</span>
                                        <p class="item-name">' . $info_item['Nom'] . '</p>
                                        <p class="item-description">' . $info_item['Description'] . '</p>
                                    </div>';
                                    $montant_total += $info_item['Prix_Achat'];
                                }
                                
                            }
                            if (isset($_GET['reduc'])){
                                $code_reduc = $_GET['reduc'];
                                $sql = "SELECT Montant, Type, TIMEDIFF(Date_exp, NOW()) AS diff, Utilisations FROM `coupon_reduc` WHERE Code = '$code_reduc'";
                                $res = mysqli_query($db_handle, $sql);
                                if (mysqli_num_rows($res) != 0) {
                                    $erreur = 0;
                                    while ($data = mysqli_fetch_assoc($res)) {
                                        if ($data['diff'] != NULL && strncasecmp($data['diff'], '-', 1) == 0)
                                            $erreur = 1;
                                        if ($data['Utilisations'] != NULL && $data['Utilisations'] <= 0)
                                            $erreur = 1;
                                        if ($erreur != 1) {
                                            if ($data['Utilisations'] != NULL) {
                                                $reduc_restant = $data['Utilisations'];
                                            }
                                            if ($data['Type'] == 1) {
                                                $montant_total = $montant_total * (1 - $data['Montant'] / 100);
                                                echo '<div class="item"><span class="price">' . ($montant_total * $data['Montant'] / 100 * -1) . '€</span>
                                                        <p class="item-name">' . $code_reduc . '</p>
                                                        <p class="item-description">Reduction de ' . ($data['Montant'] * -1) . '%</p>
                                                    </div>';
                                            }
                                            else {
                                                $montant_total = $montant_total - $data['Montant'];
                                                echo '<div class="item"><span class="price">' . ($data['Montant'] * -1) . '€</span>
                                                        <p class="item-name">' . $code_reduc . '</p>
                                                        <p class="item-description">Reduction</p>
                                                    </div>';
                                            }
                                        }
                                    }
                                }
                                else {
                                }
                            }

                            if (isset($_GET['cadeau'])) {
                                $code_cadeau = $_GET['cadeau'];
                                $sql = "SELECT Montant FROM `cheque_cadeau` WHERE Numero_Carte = '$code_cadeau'";
                                $res = mysqli_query($db_handle, $sql);
                                if (mysqli_num_rows($res) != 0) {
                                    while ($data = mysqli_fetch_assoc($res)) {
                                        if ($data['Montant'] > 0) {
                                            if ($data['Montant'] < $montant_total) {
                                                echo '<div class="item"><span class="price">' . ($data['Montant'] * -1) . '€</span>
                                                        <p class="item-name">Cheque Cadeau</p>
                                                        <p class="item-description">Utilisation de ' . $data['Montant'] . '€ du cheque cadeau :' . $code_cadeau . '</p>
                                                    </div>';
                                                $montant_total = $montant_total - $data['Montant'];
                                            }
                                            else {
                                                $cadeau_restant = $data['Montant'] - $montant_total;
                                                echo '<div class="item"><span class="price">' . $montant_total . '€</span>
                                                        <p class="item-name">Cheque Cadeau</p>
                                                        <p class="item-description">Utilisation de ' . $montant_total. '€ du cheque cadeau :' . $code_cadeau . '<br>Montant restant : ' . $cadeau_restant . '€</p>
                                                    </div>';
                                                $montant_total = 0;
                                            }
                                        }
                                    }
                                }
                            }

                            echo '<div class="total"><span>Total</span><span class="price">' . $montant_total . '€</span></div>';
                        ?>
                    </div>
                    <div class="card-details">
                        <h3 class="title">Options</h3>
                        <div class="form-row">
                            <div class="col-sm-8">
                                <div class="form-group"><label for="card-holder">Carte cadeau</label><input class="form-control" type="text" name="cadeau" placeholder="Carte cadeau"<?php if (isset($_GET['cadeau'])) echo 'value="' . $_GET['cadeau'] . '"'; ?>></div>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-secondary btn-block btn-sm" type="submit" name="btn_option">Utiliser</button>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group"><label for="card-number">Code de reduction</label><input class="form-control" type="text" id="card-number" name="reduc" placeholder="Code de reduction"<?php if (isset($_GET['reduc'])) echo 'value="' . $_GET['reduc'] . '"'; ?>></div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group"><button class="btn btn-secondary btn-block btn-sm" type="submit" name="btn_option">Appliquer</button></div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><?php $id = $_SESSION['user_ID']; $sql = "SELECT cb.Numero_Carte, type_carte.Nom FROM carte_bancaire AS cb, type_carte WHERE cb.ID_User = '$id' AND type_carte.ID = cb.Type"; $result = mysqli_query($db_handle, $sql); if (mysqli_num_rows($result) == 0) { echo '<a data-target="#Modal_add_carte" data-toggle="modal" href="#">Ajouter nouvelle carte de paiement</a>';
                                } /*else { echo '<select>'; while ($data = mysqli_fetch_assoc($result)) { $num_carte_confidentiel = substr_replace($data['Numero_Carte'], '***-', 0, -4); echo '<option value="' . $data['Numero_Carte'] . '">' . $num_carte_confidentiel . ", " . $data['Nom']; } echo '</select>'; }*/ ?></div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="paiement.php" method="post">
                    <div class="card-details">
                        <h3 class="title">Carte bancaire</h3>
                        <div class="row">
                                <?php 
                                    $id = $_SESSION['user_ID'];
                                    $sql = "SELECT Carte_Paiement FROM utilisateur WHERE ID = '$id'";
                                    $res = mysqli_query($db_handle, $sql);
                                    $info_res = mysqli_fetch_assoc($res);

                                    if (!empty($info_res['Carte_Paiement'])) {
                                        $num_carte = $info_res['Carte_Paiement'];
                                        $sql = "SELECT Nom_Proprietaire, MONTH(Date_exp) AS MM, YEAR(Date_exp) AS YYYY, CVV FROM carte_bancaire WHERE Numero_Carte = '$num_carte'";
                                        $res = mysqli_query($db_handle, $sql);
                                        while ($data = mysqli_fetch_assoc($res)) {
                                            echo '<div class="col-sm-7">
                                    <div class="group"><label for="card-holder">Proprietaire de la carte</label><input class="form-control" type="text" name="nom" value="' . $data['Nom_Proprietaire'] . '" required></div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="group"><label>Date d\'expiration</label>
                                        <div class="input-group expiration-date"><input class="form-control" type="text" minlength="2" maxlength="2" name="mois" value="' . $data['MM'] . '" required><input class="form-control" type="text" minlength="4" maxlength="4" name="annee" value="' . $data['YYYY'] . '" required></div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="group"><label for="card-number">Numéro de carte</label><input class="form-control" type="text" minlength="16" maxlength="16" name="num_carte" id="card-number" value="' . $num_carte . '" required></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="group"><label for="cvv">CVV</label><input class="form-control" type="text" minlength="3" maxlength="3" id="cvv" name="cvv" value="' . $data['CVV'] . '" required></div>
                                </div>
                                <div class="col-sm-12">';
                                        }
                                    }
                                    else {
                                        echo '<div class="col-sm-7">
                                    <div class="group"><label for="card-holder">Proprietaire de la carte</label><input class="form-control" type="text" name="nom" placeholder="Propietaire de la carte" required></div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="group"><label>Date d\'expiration</label>
                                        <div class="input-group expiration-date"><input class="form-control" type="text" minlength="2" maxlength="2" name="mois" placeholder="MM" required><input class="form-control" type="text" minlength="2" maxlength="2" name="annee" placeholder="YYYY" required></div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="group"><label for="card-number">Numéro de carte</label><input class="form-control" type="text" minlength="16" maxlength="16" name="num_carte" id="card-number" placeholder="Numero carte" required></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="group"><label for="cvv">CVV</label><input class="form-control" type="text" minlength="3" maxlength="3" id="cvv" name="cvv" placeholder="CVV" required></div>
                                </div>
                                <div class="col-sm-12">';
                                    }
                                    echo '<div class="group"><button class="btn btn-primary btn-block" data-test="Az" value="' . $montant_total . '" name="payer">Proceed</button></div>
                                </div>';
                                    echo '<input type="text" value="' . $code_reduc . '" name="code_reduc" hidden>';
                                    echo '<input type="number" value="' . $reduc_restant . '" name="reduc_restant" hidden>';
                                    echo '<input type="text" value="' . $code_cadeau . '" name="code_cadeau" hidden>';
                                    echo '<input type="text" value="' . $cadeau_restant . '" name="cadeau_restant" hidden>';
                                 ?>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Text</p>
        </div>
    </footer>
</body>

</html>