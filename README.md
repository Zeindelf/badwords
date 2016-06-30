# Badwords

Filtro para censura de palavrões/palavras inapropriadas.

## Instalação

Instale via composer: `$ composer require zeindelf/badwords`

## Uso

### Verificação simples

```php
$verify = Badwords\Badwords::verify(/* sua palavra a ser verificada */);

if ( $verify ) {
	echo 'Badwords!';
}
```

### Adicionando palavras

Você precisa criar um array com o índice `'badwords'` e setar um array com as palavras que deseja acrescentar.

```php
$extra = [
	'badwords' => ['rocks'],
];

$verify = Badwords\Badwords::verify('rocks', $extra);

if ( $verify ) {
	echo 'Badwords!';
}
```

### Excluindo palavras

Você precisa criar um array com o índice `'ignored'` e setar um array com as palavras que deseja ignorar.

Se a palavra for válida na configuração original, ela deixará de ser considerada, retornando `false` na verificação.

A lista de todas as palavras do filtro encontra-se em: `src/Config/Filter.php`

```php
$extra = [
	'ignored' => ['cadela'],
];

$verify = Badwords\Badwords::verify('cadela', $extra);

if ( ! $verify ) {
	echo 'Cadela é uma palavra válida';
}
```

### Usando ambos

```php
$extra = [
	'badwords' => ['rocks'],
	'ignored'  => ['cadela'],
];
```
A palavra `'rocks'` será considerada no filtro ao mesmo tempo que a palavra `'cadela'` será ignorada.