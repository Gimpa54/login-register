<?php
namespace App\Utils;

use App\Utils\Csrf;

class FormHelper
{
    /**
     * 📌 Restituisce un campo input hidden contenente il token CSRF.
     * 💡 Usalo dentro ogni <form> per protezione contro CSRF.
     *
     * Esempio in una view:
     * <?= FormHelper::csrfInput() ?>
     */
    public static function csrfInput(): string
    {
        $token = Csrf::getOrCreateToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    
    /**
     * 📌 Recupera il valore precedente di un campo (POST o sessione).
     * 💡 Utile per mantenere i dati nei form in caso di errore.
     *
     * Esempio:
     * <input name="email" value="<?= FormHelper::old('email') ?>">
     */
    public static function old(string $name, $default = ''): string
    {
        $value = $_POST[$name] ?? $_SESSION['old'][$name] ?? $default;
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * 📌 Mostra un messaggio di errore per il campo specificato (se presente in sessione).
     * 💡 Da usare sotto ogni campo nei form.
     *
     * Esempio:
     * <?= FormHelper::error('email') ?>
     */
    public static function error(string $name): string
    {
        if (!empty($_SESSION['errors'][$name])) {
            $msg = htmlspecialchars($_SESSION['errors'][$name], ENT_QUOTES, 'UTF-8');
            return "<div class=\"text-danger small\">{$msg}</div>";
        }
        return '';
    }

    /**
     * 📌 Genera un campo input con label e gestione errori.
     * 💡 Supporta tipo, valore di default e attributi extra.
     * 
     * Esempio:
     * <?= FormHelper::input('email', 'Email', 'email') ?>
     */
    public static function input(string $name, string $label, string $type = 'text', $default = '', array $attributes = []): string
    {
        $value = self::old($name, $default);
        $errorHtml = self::error($name);
        
        $attrString = '';
        foreach ($attributes as $attr => $val) {
            $attrString .= ' ' . htmlspecialchars($attr, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8') . '"';
        }
        
        return <<<HTML
        <div class="form-group mb-3">
            <label class="form-label" for="{$name}">{$label}</label>
            <input type="{$type}" name="{$name}" id="{$name}" value="{$value}" class="form-control"{$attrString}>
            {$errorHtml}
        </div>
        HTML;
    }
    
    /**
     * 📌 Genera una textarea con label e gestione errori.
     * 💡 Perfetta per campi di testo estesi come descrizioni.
     *
     * Esempio:
     * <?= FormHelper::textarea('bio', 'Biografia') ?>
     */
    public static function textarea(string $name, string $label, $default = ''): string
    {
        $value = self::old($name, $default);
        $errorHtml = self::error($name);
        
        return <<<HTML
        <div class="form-group mb-3">
            <label class="form-label" for="{$name}">{$label}</label>
            <textarea name="{$name}" id="{$name}" class="form-control">{$value}</textarea>
            {$errorHtml}
        </div>
        HTML;
    }
    
    /**
     * 📌 Genera un menu a discesa <select> con opzioni.
     * 💡 Usa un array associativo (value => label) e può essere richiesto.
     *
     * Esempio:
     * <?= FormHelper::select('role', 'Ruolo', ['admin' => 'Admin', 'user' => 'Utente'], 'user') ?>
     */
    public static function select(string $name, string $label, array $options = [], $selected = null, bool $required = false): string
    {
        $requiredAttr = $required ? 'required' : '';
        $selectedValue = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST[$name] ?? null) : $selected;
        
        $html = "<div class=\"form-group mb-3\">\n";
        $html .= "<label class=\"form-label\" for=\"{$name}\">{$label}</label>\n";
        $html .= "<select name=\"{$name}\" id=\"{$name}\" class=\"form-select\" {$requiredAttr}>\n";
        $html .= "<option value=\"\">--Seleziona--</option>\n";
        
        foreach ($options as $value => $text) {
            $isSelected = ($value == $selectedValue) ? 'selected' : '';
            $html .= "<option value=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\" {$isSelected}>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</option>\n";
        }
        
        $html .= "</select>\n" . self::error($name) . "\n</div>\n";
        return $html;
    }
    
    /**
     * 📌 Genera una checkbox singola con etichetta.
     * 💡 Valore = true se selezionata. Utile per accettare termini o booleani.
     *
     * Esempio:
     * <?= FormHelper::checkbox('newsletter', 'Iscriviti alla newsletter') ?>
     */
    public static function checkbox(string $name, string $label, $checked = false): string
    {
        $isChecked = (isset($_POST[$name]) || $checked) ? 'checked' : '';
        $errorHtml = self::error($name);

        return <<<HTML
        <div class="form-check mb-3">
            <input type="checkbox" name="{$name}" id="{$name}" class="form-check-input" {$isChecked}>
            <label for="{$name}" class="form-check-label">{$label}</label>
            {$errorHtml}
        </div>
        HTML;
    }
    
    /**
     * 📌 Genera una lista di checkbox multiple (es. per selezione multipla di opzioni).
     * 💡 Usa un nome con [] per array di valori.
     *
     * Esempio:
     * <?= FormHelper::checkboxList('tags[]', 'Seleziona tag', ['php' => 'PHP', 'js' => 'JS'], ['php']) ?>
     */
    public static function checkboxList(string $name, string $label, array $options, array $selected = []): string {
        
        if (!is_array($options)) $options = [];
        if (!is_array($selected)) $selected = [];
        
        $baseName = str_replace('[]', '', $name);
        
        // Se siamo in POST, usa $_POST, altrimenti usa i valori passati
        $selectedValues = $_SERVER['REQUEST_METHOD'] === 'POST'
            ? ($_POST[$baseName] ?? [])
            : $selected;
            
            $html = "<label class='form-label'>{$label}</label><div>";
            foreach ($options as $value => $text) {
                $isChecked = in_array($value, $selectedValues) ? 'checked' : '';
                $id = "{$baseName}_{$value}";
                $html .= "<div class='form-check form-check-inline'>";
                $html .= "<input class='form-check-input' type='checkbox' name='{$name}' id='{$id}' value='{$value}' {$isChecked}>";
                $html .= "<label class='form-check-label' for='{$id}'>{$text}</label>";
                $html .= "</div>";
            }
            $html .= "</div>";
            return $html;
    }
    
    /**
     * 📌 Genera un gruppo di radio button per una scelta singola.
     * 💡 Può usare un array personalizzato o valori predefiniti (es. 'type').
     *
     * Esempio:
     * <?= FormHelper::radio('type', ['admin' => 'Admin', 'user' => 'Utente']) ?>
     */
    public static function radio(string $name, array $options = [], $selected = null): string
    {
        if (empty($options)) {
            $options = self::getDefaultOptions($name);
        }

        $html = "<div class=\"form-group mb-3\">\n";

        foreach ($options as $value => $label) {
            $isChecked = (self::old($name, $selected) == $value) ? 'checked' : '';
            $html .= <<<HTML
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{$name}" id="{$name}_{$value}" value="{$value}" {$isChecked}>
                <label class="form-check-label" for="{$name}_{$value}">{$label}</label>
            </div>
            HTML;
        }

        $html .= self::error($name) . "\n</div>\n";
        return $html;
    }
    
    /**
     * 📌 Genera un campo file per upload, accetta PDF o immagini.
     * 💡 Da usare con enctype="multipart/form-data".
     *
     * Esempio:
     * <?= FormHelper::file('documento', 'Allega documento') ?>
     */
    public static function file(string $name, string $label, bool $required = false): string
    {
        $errorHtml = self::error($name);
        $requiredAttr = $required ? 'required' : '';
        
        return <<<HTML
        <div class="form-group mb-3">
            <label class="form-label" for="{$name}">{$label}</label>
            <input type="file" name="{$name}" id="{$name}" class="form-control" accept="application/pdf,image/*" {$requiredAttr}>
            {$errorHtml}
        </div>
        HTML;
    }
    
    public static function group(array $columns): string
    {
        $html = '<div class="row">';
        foreach ($columns as [$colClass, $content]) {
            $html .= '<div class="' . htmlspecialchars($colClass) . '">' . $content . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
    
    public static function section(string $title = '', string $content = ''): string
    {
        $html = '<div class="form-section mb-4 p-3 border rounded bg-light-subtle">';
        if ($title) {
            $html .= '<h5 class="mb-3 border-bottom pb-2">' . htmlspecialchars($title) . '</h5>';
        }
        $html .= $content;
        $html .= '</div>';
        return $html;
    }
    
    public static function separator(string $label = ''): string
    {
        $labelHtml = $label ? '<div class="fw-semibold mb-2">' . htmlspecialchars($label) . '</div>' : '';
        return <<<HTML
            <div class="form-separator my-4">
                {$labelHtml}
                <hr class="border border-secondary-subtle">
            </div>
        HTML;
    }
    
    /**
     * 📌 Crea un array di opzioni per select/checkbox/radio da un array o oggetto.
     * 💡 Utile per estrarre [id => 'Nome Cognome'] da oggetti utenti o altro.
     *
     * Esempio:
     * $options = FormHelper::generateOptions($users, 'id', 'firstname', 'lastname');
     */
    public static function generateOptions(array $items, string $keyField, string $valueField1, string $valueField2 = null): array
    {
        $options = [];

        foreach ($items as $item) {
            // Se è un array
            if (is_array($item)) {
                $key = $item[$keyField] ?? '';
                $val1 = $item[$valueField1] ?? '';
                $val2 = $valueField2 ? ($item[$valueField2] ?? '') : '';
            } // Se è un oggetto
            else {
                $key = $item->$keyField ?? '';
                $val1 = $item->$valueField1 ?? '';
                $val2 = $valueField2 ? ($item->$valueField2 ?? '') : '';
            }

            $value = $val2 ? $val1 . ' ' . $val2 : $val1;
            $options[$key] = $value;
        }

        return $options;
    }

    /**
     * 📌 Genera un campo file immagine con anteprima opzionale (es. avatar).
     * 💡 Mostra preview immagine esistente e consente nuova selezione.
     *
     * Esempio:
     * <?= FormHelper::imageWithPreview('avatar', 'Avatar', $user->avatar) ?>
     */
    public static function imageWithPreview(string $name, string $label, ?string $currentImagePath = null, string $uploadDir = '/uploads/', bool $required = false): string
    {
        $errorHtml = self::error($name);
        $requiredAttr = $required ? 'required' : '';
        $uploadDir = rtrim($uploadDir, '/') . '/';
        
        $previewHtml = '';
        if (!empty($currentImagePath)) {
            // Evita doppio path se currentImagePath è già un path assoluto
            $src = str_starts_with($currentImagePath, '/')
            ? htmlspecialchars($currentImagePath, ENT_QUOTES, 'UTF-8')
            : htmlspecialchars($uploadDir . $currentImagePath, ENT_QUOTES, 'UTF-8');
            
            $previewHtml = '<img src="' . $src . '" alt="Preview" width="80" class="img-thumbnail me-3">';
        }
        
        return <<<HTML
    <div class="form-group mb-3">
        <label class="form-label" for="{$name}">{$label}</label>
        <div class="d-flex align-items-center">
            {$previewHtml}
            <input type="file" name="{$name}" id="{$name}" class="form-control" accept="image/*" {$requiredAttr}>
        </div>
        {$errorHtml}
    </div>
    HTML;
    }
    
    

    /**
     * 📌 Restituisce opzioni predefinite per alcuni radio (es. 'type').
     * 💡 Interno, usato da radio() se non vengono passate opzioni.
     */
    private static function getDefaultOptions(string $name): array
    {
        $defaults = [
            'type' => [
                'admin' => 'amministratore',
                'user' => 'utente',
                'operator' => 'gestore'
            ]
        ];
        return $defaults[$name] ?? [];
    }
}
