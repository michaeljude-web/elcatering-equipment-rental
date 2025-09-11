<?php
class Category {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($name) {
        $name = trim($name);
        if (empty($name)) {
            return "Category name cannot be empty!";
        }

        $check_stmt = $this->conn->prepare("SELECT id FROM categories WHERE category_name = ?");
        $check_stmt->bind_param("s", $name);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
            return "Category name already exists!";
        }

        $stmt = $this->conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
        $check_stmt->close();

        return "Category added successfully!";
    }

    public function delete($id) {
        $id = intval($id);
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getAll($start, $limit) {
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT ?, ?");
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function count() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM categories");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>