<?php
// visitors.php
include 'config.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        listVisitors($pdo);
        break;

    case 'add':
        addVisitor($pdo);
        break;

    case 'delete':
        deleteVisitor($pdo);
        break;

    case 'edit':
        editVisitor($pdo);
        break;

    default:
        echo json_encode(["error" => "Ação inválida"]);
}

function listVisitors($pdo) {
    $stmt = $pdo->query("SELECT * FROM visitors ORDER BY created_at DESC");
    $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($visitors);
}

function addVisitor($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? '';
    $contact = $data['contact'] ?? '';
    $reason = $data['reason'] ?? '';

    if ($name && $contact && $reason) {
        $stmt = $pdo->prepare("INSERT INTO visitors (name, contact, reason) VALUES (:name, :contact, :reason)");
        $stmt->execute(['name' => $name, 'contact' => $contact, 'reason' => $reason]);
        echo json_encode(["success" => "Visitante adicionado com sucesso"]);
    } else {
        echo json_encode(["error" => "Dados incompletos"]);
    }
}

function deleteVisitor($pdo) {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM visitors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo json_encode(["success" => "Visitante excluído com sucesso"]);
    } else {
        echo json_encode(["error" => "ID não fornecido"]);
    }
}

function editVisitor($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    $name = $data['name'] ?? '';
    $contact = $data['contact'] ?? '';
    $reason = $data['reason'] ?? '';

    if ($id && $name && $contact && $reason) {
        $stmt = $pdo->prepare("UPDATE visitors SET name = :name, contact = :contact, reason = :reason WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'contact' => $contact, 'reason' => $reason]);
        echo json_encode(["success" => "Visitante atualizado com sucesso"]);
    } else {
        echo json_encode(["error" => "Dados incompletos"]);
    }
}
?>
