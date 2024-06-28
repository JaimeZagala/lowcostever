<?php
include_once 'header.php';
if(!isset($_SESSION['usuario'])) {
	header('location: login.php');
	exit;
}
?>
<p>Cookie iniciada con nombre: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
<?php
switch($_SESSION['rol']) {
	case 1:
		echo '<p>Bienvenido, amo supremo y Dios omnipotente, omnisciente y omnipresente.</p>';
		break;
	case 2:
		echo '<p>Eres un currele</p>';
		break;
	default:
		echo '<p>Ni siquiera te conozco</p>';
		break;
}
?>
<?php include_once 'footer.php'; ?>