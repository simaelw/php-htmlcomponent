# php-htmlcomponent

## Introduction
The `HtmlComponent` class provides a simple way to create reusable HTML components. It allows you to dynamically add attributes, classes, inline styles, and content to HTML elements. You can easily create components such as `<div>`, `<input>`, `<span>`, and others, without needing to write repetitive HTML code.

## Features
- **Dynamic Component Creation:** Instantly create HTML elements by specifying the tag name.
- **CSS Classes:** Add one or more CSS classes to a component.
- **HTML Attributes:** Set any HTML attribute (e.g., `id`, `name`, `href`, etc.).
- **Inline Styles:** Add inline styles to components.
- **Content Handling:** Set textual content or nested components.
- **Self-Closing Tags:** Automatically handle self-closing tags (e.g., `<input />`, `<img />`).
- **Rendering and Output:** Get the HTML output using `render()` or print it directly using `print()`.

## Installation
To use the `HtmlComponent` class in your project, simply download the file containing the class definition and include it in your project.

## Usage
### Basic Component Creation
```php
$div = new HtmlComponent('div');
echo $div->render(); // <div></div>
```
### Adding CSS Classes
```php
$div = HtmlComponent::make('div')
    ->addClasses('container', 'shadow');
echo $div->render(); // <div class="container shadow"></div>
```
### Setting Attributes
```php
$input = HtmlComponent::make('input')
    ->addAttributes('type', 'text')
    ->addAttributes(['name' => 'username']); //or passing as array
echo $input->render(); // <input type="text" name="username">
```
### Adding Inline Styles
```php
$div = HtmlComponent::make('div')
    ->addStyles('color', 'red')
    ->addStyles('font-weight', 'bold');
echo $div->render(); // <div style="color: red; font-weight: bold;"></div>
```
### Forcing Self-Closing Tags
```php
$div = HtmlComponent::make('div')->selfClosing(true);
echo $div->render(); // <div></div>

$input = HtmlComponent::make('input')->setAttribute('type', 'text')->selfClosing(true);
echo $input->render(); // <input type="text">

$custom = HtmlComponent::make('custom')->setContent('Content')->selfClosing(false);
echo $custom->render(); // <custom>Content</custom>
```
### Setting Content
```php
$div = HtmlComponent::make('div')
    ->setContent('Hello, World!');
echo $div->render(); // <div>Hello, World!</div>
```
You can also pass multiple contents, including other components:
```php
$span = HtmlComponent::make('span')->setContent('Some text');
$div = HtmlComponent::make('div')->setContent('Text before ', $span, ' text after.');
echo $div->render(); // <div>Text before <span>Some text</span> text after.</div>
```
### Rendering and Printing
You can get the HTML output using the `render()` method:
```php
echo $div->render(); // Outputs HTML
```
Or use `print()` to directly print the component:
```php
$div->print(); // Outputs HTML directly
```
### Using `__toString()` for Direct Output
You can also omit the need to call `render()` or `print()` methods by using the magic `__toString()` method. This allows you to directly echo or print the component when it's treated as a string.
Example:
```php
$div = HtmlComponent::make('div')
    ->addClasses('container')
    ->setContent('Hello, World!');

echo $div; // Automatically calls $div->__toString(), which internally calls render()
```
The `__toString()` method is automatically invoked when the object is used in a string context (like echo or print). This simplifies the code by eliminating the need for explicit rendering functions.

## Methods and Functionality
- `make()`: A static method to create an instance of the component.
- `addClasses()`: Adds one or more CSS classes to the component.
- `addAttributes()`: Sets one or more HTML attributes for the component.
- `addStyles()`: Adds one or more inline styles to the component.
- `selfClosing()`: To force the tag to be self-closing or not when necessary.
- `setContent()`: Sets the content for the component (can be a string or other components).
- `render()`: Returns the HTML representation of the component as a string.
- `print()`: Outputs the HTML representation directly to the page.

## Advanced Usage
- **Complex Nested Structures:** You can nest components within each other to create more complex layouts, such as forms with inputs and labels.
- **Custom Tags:** If needed, you can extend the class to create your own custom tags.

Example of a form component:

```php
$form = HtmlComponent::make('form')
    ->setAttribute('action', '/submit')
    ->setAttribute('method', 'POST')
    ->setContent(
        HtmlComponent::make('input')->setAttribute('type', 'text')->setAttribute('name', 'username'),
        HtmlComponent::make('input')->setAttribute('type', 'password')->setAttribute('name', 'password')
    );
echo $form->render();
```

## Contributing
If you would like to contribute to this project, feel free to fork the repository and submit a pull request. If you find any bugs or issues, please report them via the "Issues" section.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.
