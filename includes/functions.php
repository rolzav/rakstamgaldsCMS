<?php
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function isEditor()
{
    return isLoggedIn() && ($_SESSION['role'] === 'editor' || $_SESSION['role'] === 'admin');
}

function generateSlug($string)
{
    $transliterationTable = [
        ' ' => '-',
        'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'Ae', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', 'Ā' => 'A', 'ā' => 'a', 'Ē' => 'E', 'ē' => 'e', 'Ī' => 'I', 'ī' => 'i', 'Ō' => 'O', 'ō' => 'o',
        'Ū' => 'U', 'ū' => 'u', 'č' => 'c', 'š' => 's', 'ķ' => 'k', 'š' => 's', 'ļ' => 'l', 'ž' => 'z', 'ņ' => 'n', 'ģ' => 'g',
    ];

    $string = strtr($string, $transliterationTable);
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

function getBreadcrumbs($category_id)
{
    $db = Database::getInstance()->getConnection();
    $breadcrumbs = [];

    while ($category_id) {
        $stmt = $db->prepare("SELECT id, name, slug, parent_id FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            array_unshift($breadcrumbs, $category);
            $category_id = $category['parent_id'];
        } else {
            break;
        }
    }

    return $breadcrumbs;
}

function buildCategoryTree($categories, $parent_id = null, $level = 0)
{
    $tree = [];
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parent_id) {
            $category['level'] = $level;
            $tree[] = $category;
            $tree = array_merge($tree, buildCategoryTree($categories, $category['id'], $level + 1));
        }
    }
    return $tree;
}
?>
