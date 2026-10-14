<?php
declare(strict_types=1);

/**
 * Calculadora de longevidad (versión PHP).
 * Un único archivo: formulario, validación, cálculo y justificación.
 * Estimación orientativa basada en estudios publicados; no es consejo médico.
 */

const BASE_POR_DEFECTO = 83.0;

/* ---------- Utilidades ---------- */

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function fmt(float $n, int $dec = 1): string
{
    return number_format($n, $dec, ',', '.');
}

function sgn(float $n): string
{
    $signo = $n > 0 ? '+' : ($n < 0 ? '−' : '');
    return $signo . fmt(abs($n));
}

/* ---------- Datos: preguntas, opciones, ajustes en años y justificación ---------- */

$preguntas = [
    'tabaco' => [
        'nombre' => 'Tabaco',
        'texto'  => '¿Fumas o has fumado?',
        'ayuda'  => 'Cuenta cigarrillos, puros y pipa.',
        'fuente' => 'Jha et al., N Engl J Med 2013.',
        'defecto' => 'ex_antes',
        'opciones' => [
            'nunca' => ['Nunca he fumado', 0.0,
                'Sin consumo de tabaco no se aplica ningún ajuste. Es la referencia.', ''],
            'ex_antes' => ['Lo dejé antes de los 40', -1.0,
                'Quien deja de fumar entre los 25 y los 34 años gana en torno a 10 años frente a seguir fumando, y queda cerca de la esperanza de vida de quien nunca fumó. Se descuenta 1 año por el riesgo que queda.', ''],
            'ex_despues' => ['Lo dejé a los 40 o después', -3.0,
                'Dejarlo entre los 45 y los 64 años recupera entre 4 y 6 años frente a seguir fumando, pero queda parte del exceso de riesgo. Se estima una pérdida residual de unos 3 años.',
                'Ya has hecho lo más importante. Mantener la abstinencia y revisar el pulmón con tu médico si tienes más de 50 años es lo que más aporta ahora.'],
            'actual' => ['Fumo actualmente', -10.0,
                'Los fumadores actuales pierden de media unos 10 años de vida respecto a quienes nunca han fumado. Dejarlo recupera parte de ellos a cualquier edad.',
                'Dejar de fumar es la palanca más grande que existe: a los 35-44 años recupera unos 9 años, y a los 55-64 todavía unos 4.'],
        ],
    ],
    'actividad' => [
        'nombre' => 'Actividad física',
        'texto'  => '¿Cuánta actividad física haces a la semana?',
        'ayuda'  => 'Suma caminar a paso ligero, bici, deporte o trabajo físico. 150 minutos semanales es la recomendación de la OMS.',
        'fuente' => 'Moore et al., PLoS Med 2012.',
        'defecto' => 'oms',
        'opciones' => [
            'nada' => ['Casi nada (menos de 15 minutos)', -1.8,
                'En el análisis de Moore et al., las personas inactivas viven unos 1,8 años menos que las que hacen algo de ejercicio por debajo de la recomendación.',
                'Con solo 15 minutos diarios de paseo a buen paso se pasa a un nivel con mejor esperanza de vida.'],
            'poco' => ['Algo (de 15 a 149 minutos)', 0.0,
                'Es el nivel de referencia: algo de actividad, por debajo de la recomendación.', ''],
            'oms' => ['Entre 150 y 449 minutos', 1.6,
                'Con 150 minutos semanales de actividad moderada se ganan unos 3,4 años frente a la inactividad. Son unos 1,6 más que quien hace poco.', ''],
            'mucho' => ['450 minutos o más', 2.7,
                'Con unos 450 minutos semanales la ganancia llega a unos 4,5 años frente a la inactividad, 2,7 más que quien hace poco. Por encima de ese nivel el beneficio crece muy despacio.', ''],
        ],
    ],
    'alcohol' => [
        'nombre' => 'Alcohol',
        'texto'  => '¿Cuántas bebidas alcohólicas tomas a la semana?',
        'ayuda'  => 'Una bebida estándar equivale a unos 10 g de alcohol: una caña, una copa de vino o un vermut pequeño.',
        'fuente' => 'Wood et al., Lancet 2018.',
        'defecto' => 'b2',
        'opciones' => [
            'b1' => ['Ninguna o hasta 10', 0.0,
                'Hasta unos 100 g de alcohol puro a la semana es el tramo de referencia de Wood et al., sin pérdida apreciable de esperanza de vida.', ''],
            'b2' => ['De 11 a 20', -0.5,
                'Entre 100 y 200 g de alcohol a la semana se asocia, a los 40 años, con unos 6 meses menos de vida respecto al tramo de referencia.', ''],
            'b3' => ['De 21 a 35', -1.5,
                'Entre 200 y 350 g semanales se asocian con entre 1 y 2 años menos de esperanza de vida.',
                'Bajar al tramo de hasta 10 bebidas semanales elimina este descuento.'],
            'b4' => ['Más de 35', -4.5,
                'Más de 350 g semanales se asocian con entre 4 y 5 años menos de esperanza de vida.',
                'Reducir el consumo es el cambio con más efecto en tu perfil. Si te cuesta, el médico de cabecera puede ayudarte.'],
        ],
    ],
    'dieta' => [
        'nombre' => 'Alimentación',
        'texto'  => '¿Cómo describirías tu alimentación habitual?',
        'ayuda'  => 'Piensa en lo que comes la mayoría de los días, no en las comidas especiales.',
        'fuente' => 'Fadnes et al., PLoS Med 2022; PREDIMED, N Engl J Med 2018.',
        'defecto' => 'mixta',
        'opciones' => [
            'mala' => ['Mucha carne roja o procesada, bollería, refrescos y comida precocinada', -2.0,
                'El patrón occidental típico, con mucha carne procesada y pocos alimentos vegetales, es el extremo que modelan Fadnes et al. Se aplica una fracción prudente de su estimación.',
                'Cambiar carne procesada por legumbres y frutos secos es el cambio que más pesa en los modelos de Fadnes et al.'],
            'mixta' => ['Mezclada: algo de verdura y fruta, algo de procesados', 0.0,
                'Término medio de la población. No se aplica ajuste.', ''],
            'med' => ['Mediterránea: legumbres, verdura, fruta, pescado, aceite de oliva y frutos secos', 2.5,
                'Se acerca al patrón óptimo de Fadnes et al., que estimaron hasta unos 10 años de ganancia si se adopta a los 20 años, y menos a edades mayores. El ensayo PREDIMED apoya el beneficio cardiovascular. Se aplica una fracción conservadora.', ''],
        ],
    ],
];

/** Tramos de IMC: [límite superior exclusivo, etiqueta, ajuste en años, justificación, consejo] */
$tramosImc = [
    [18.5, 'bajo peso', -2.0,
        'El bajo peso también se asocia con más mortalidad en la Prospective Studies Collaboration. El ajuste de unos 2 años es una aproximación.', ''],
    [25.0, 'peso normal', 0.0,
        'Es el tramo con menor mortalidad en los grandes metaanálisis, con el mínimo entre 22,5 y 25. No se aplica ajuste.', ''],
    [30.0, 'sobrepeso', -0.5,
        'El sobrepeso se asocia con un aumento pequeño de la mortalidad, y la diferencia depende de otros factores de riesgo. Se resta medio año.', ''],
    [35.0, 'obesidad grado I', -3.0,
        'Con un IMC de 30 a 35, la Prospective Studies Collaboration estimó entre 2 y 4 años menos de vida.',
        'Perder peso de forma sostenida y mantener la actividad física es lo que más puede cambiar tu estimación.'],
    [40.0, 'obesidad grado II', -6.0,
        'Tramo intermedio entre las estimaciones publicadas para IMC de 30 a 35 (de 2 a 4 años) y de 40 a 45 (de 8 a 10 años). Es una interpolación.',
        'Perder peso de forma sostenida es lo que más puede cambiar tu estimación. Tu médico puede orientarte.'],
    [INF, 'obesidad grado III', -9.0,
        'Con un IMC de 40 a 45 se estimó una pérdida de entre 8 y 10 años.',
        'Perder peso con seguimiento médico es lo que más puede cambiar tu estimación.'],
];

$referencias = [
    'Jha P, et al. 21st-century hazards of smoking and benefits of cessation in the United States. N Engl J Med. 2013;368:341-350.',
    'Moore SC, et al. Leisure time physical activity of moderate to vigorous intensity and mortality. PLoS Med. 2012;9(11):e1001335.',
    'Wood AM, et al. Risk thresholds for alcohol consumption: combined analysis of individual-participant data for 599,912 current drinkers. Lancet. 2018;391:1513-1523.',
    'Prospective Studies Collaboration. Body-mass index and cause-specific mortality in 900,000 adults. Lancet. 2009;373:1083-1096.',
    'Fadnes LT, et al. Estimating impact of food choices on life expectancy: a modeling study. PLoS Med. 2022;19(2):e1003889.',
    'Estruch R, et al. Primary prevention of cardiovascular disease with a Mediterranean diet supplemented with extra-virgin olive oil or nuts (PREDIMED, versión revisada). N Engl J Med. 2018;378:e34.',
];

/* ---------- Lectura y validación de la entrada ---------- */

$esEnvio = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
$errores = [];

// Valores del formulario: los enviados o, si es la primera visita, un ejemplo.
$valores = ['base' => '83', 'altura' => '172', 'peso' => '70'];
foreach ($preguntas as $id => $p) {
    $valores[$id] = $p['defecto'];
}

if ($esEnvio) {
    foreach (['base', 'altura', 'peso'] as $campo) {
        $valores[$campo] = trim((string)($_POST[$campo] ?? ''));
    }
    foreach ($preguntas as $id => $p) {
        $enviado = (string)($_POST[$id] ?? '');
        // Lista blanca: solo se acepta una clave de opción que exista.
        if (array_key_exists($enviado, $p['opciones'])) {
            $valores[$id] = $enviado;
        } else {
            $errores[] = 'Elige una opción en «' . $p['nombre'] . '». Se ha usado la opción de ejemplo.';
        }
    }
}

function numero(string $s): ?float
{
    $s = str_replace(',', '.', $s);
    $v = filter_var($s, FILTER_VALIDATE_FLOAT);
    return $v === false ? null : (float)$v;
}

/* ---------- Cálculo ---------- */

$filas = [];
$base = BASE_POR_DEFECTO;
$total = null;
$imcTexto = '';

if ($esEnvio) {
    $b = numero($valores['base']);
    if ($b !== null && $b >= 60 && $b <= 95) {
        $base = $b;
    } else {
        $errores[] = 'El punto de partida debe estar entre 60 y 95 años. Se han usado 83.';
        $valores['base'] = '83';
    }

    foreach ($preguntas as $id => $p) {
        [$etiqueta, $delta, $porque, $consejo] = $p['opciones'][$valores[$id]];
        $filas[] = [
            'nombre' => $p['nombre'], 'delta' => $delta, 'eleccion' => $etiqueta,
            'porque' => $porque, 'consejo' => $consejo, 'fuente' => $p['fuente'],
        ];
    }

    // Peso corporal: se calcula el IMC a partir de altura y peso.
    $altura = numero($valores['altura']);
    $peso = numero($valores['peso']);
    $datosValidos = $altura !== null && $peso !== null
        && $altura >= 120 && $altura <= 220 && $peso >= 30 && $peso <= 250;

    if ($datosValidos) {
        $imc = $peso / (($altura / 100) ** 2);
        foreach ($tramosImc as [$limite, $nombreTramo, $delta, $porque, $consejo]) {
            if ($imc < $limite) {
                $imcTexto = 'IMC ' . fmt($imc) . ' (' . $nombreTramo . ')';
                $filas[] = [
                    'nombre' => 'Peso corporal', 'delta' => $delta, 'eleccion' => $imcTexto,
                    'porque' => $porque, 'consejo' => $consejo,
                    'fuente' => 'Prospective Studies Collaboration, Lancet 2009.',
                ];
                break;
            }
        }
    } else {
        $errores[] = 'Introduce una altura entre 120 y 220 cm y un peso entre 30 y 250 kg. Este factor no se ha tenido en cuenta.';
        $filas[] = [
            'nombre' => 'Peso corporal', 'delta' => 0.0, 'eleccion' => 'Sin datos válidos',
            'porque' => 'Faltan datos válidos de altura y peso, así que este factor no se tiene en cuenta.',
            'consejo' => '', 'fuente' => 'Prospective Studies Collaboration, Lancet 2009.',
        ];
    }

    $suma = array_sum(array_column($filas, 'delta'));
    $total = $base + $suma;

    // Factor que más resta (para el mensaje de "palanca").
    $peor = $filas[0];
    foreach ($filas as $f) {
        if ($f['delta'] < $peor['delta']) {
            $peor = $f;
        }
    }
}

function marcado(array $valores, string $id, string $clave): string
{
    return $valores[$id] === $clave ? ' checked' : '';
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Calculadora de longevidad</title>
<style>
  :root {
    color-scheme: light dark;
    --bg: #F2F5F6; --surface: #FFFFFF; --fg: #12222B; --muted: #54656E; --line: #D3DCE0; --track: #E4EBEE;
    --accent: #0A6B6B; --accent-ink: #FFFFFF; --gain: #0F7A55; --loss: #B23A2B;
  }
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #0E171C; --surface: #16232A; --fg: #E6EEF1; --muted: #9BB0B9; --line: #2A3A42; --track: #1F2F37;
      --accent: #4CC3C0; --accent-ink: #06201F; --gain: #4FCB9A; --loss: #F08A78;
    }
  }
  * { box-sizing: border-box; }
  body { margin: 0; background: var(--bg); color: var(--fg); font: 17px/1.55 system-ui, "Segoe UI", sans-serif; padding: 36px 16px 64px; }
  .wrap { max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: 28px; }
  h1 { font-size: clamp(30px, 7vw, 48px); line-height: 1.08; margin: 0 0 12px; letter-spacing: -0.02em; }
  h2 { font-size: 24px; margin: 0 0 12px; }
  h3 { font-size: 18px; margin: 0; }
  p { margin: 0; }
  .eyebrow { font: 500 12px/1.2 ui-monospace, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: var(--accent); margin: 0 0 10px; }
  .muted, .help { color: var(--muted); }
  .help { font-size: 15px; }
  form { display: flex; flex-direction: column; gap: 22px; }
  fieldset { border: 0; margin: 0; padding: 0; min-width: 0; display: flex; flex-direction: column; gap: 10px; }
  legend { padding: 0; font-size: 20px; font-weight: 700; margin-bottom: 2px; }
  .qtag { display: block; font: 500 12px/1.2 ui-monospace, Menlo, monospace; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 6px; }
  .opts { display: grid; gap: 8px; grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr)); }
  label.opt { display: flex; gap: 10px; align-items: flex-start; padding: 11px 13px; border: 1px solid var(--line); border-radius: 6px; background: var(--surface); cursor: pointer; line-height: 1.35; }
  label.opt:has(input:checked) { border-color: var(--accent); background: color-mix(in srgb, var(--accent) 10%, var(--surface)); }
  label.opt input { margin-top: 3px; accent-color: var(--accent); }
  .fields { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr)); }
  .field { display: flex; flex-direction: column; gap: 6px; }
  .field span { font-size: 14px; color: var(--muted); }
  input[type=text], input[type=number] { font: 500 18px/1.2 ui-monospace, Menlo, monospace; color: var(--fg); background: var(--surface); border: 1px solid var(--line); border-radius: 6px; padding: 10px 12px; width: 100%; }
  button { align-self: flex-start; font: 600 16px/1 system-ui, sans-serif; background: var(--accent); color: var(--accent-ink); border: 0; border-radius: 6px; padding: 14px 22px; cursor: pointer; }
  :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
  .errores { border: 1px solid var(--loss); border-radius: 6px; padding: 12px 16px; color: var(--loss); }
  .errores ul { margin: 0; padding-left: 20px; }
  .result { background: var(--surface); border: 1px solid var(--line); border-radius: 12px; padding: 24px; display: flex; flex-direction: column; gap: 20px; }
  .big { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; }
  .big strong { font-size: clamp(60px, 16vw, 104px); line-height: 1; letter-spacing: -0.04em; color: var(--accent); }
  .big span, .breakdown { font: 14px/1.5 ui-monospace, Menlo, monospace; color: var(--muted); }
  .bars { display: flex; flex-direction: column; gap: 12px; }
  .barrow { display: grid; grid-template-columns: 1fr auto; gap: 4px 12px; align-items: center; }
  .barrow .name { font-weight: 600; }
  .val { font: 500 15px/1 ui-monospace, Menlo, monospace; }
  .track { grid-column: 1 / -1; position: relative; height: 14px; background: var(--track); border-radius: 3px; }
  .track::after { content: ""; position: absolute; left: 50%; top: -3px; bottom: -3px; width: 1px; background: var(--muted); }
  .fill { position: absolute; top: 0; bottom: 0; border-radius: 3px; }
  .gain .fill, .fill.gain { left: 50%; background: var(--gain); }
  .fill.loss { right: 50%; background: var(--loss); }
  .val.gain, .chip.gain { color: var(--gain); } .val.loss, .chip.loss { color: var(--loss); } .chip.zero { color: var(--muted); }
  .scale { display: flex; justify-content: space-between; font: 12px/1 ui-monospace, Menlo, monospace; color: var(--muted); }
  .lever { padding: 14px 16px; border-radius: 6px; background: color-mix(in srgb, var(--accent) 9%, var(--surface)); border: 1px solid color-mix(in srgb, var(--accent) 35%, var(--line)); }
  .why { display: flex; flex-direction: column; gap: 14px; }
  .factor { background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 18px; display: flex; flex-direction: column; gap: 8px; }
  .factor header { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; flex-wrap: wrap; }
  .chip { font: 500 14px/1 ui-monospace, Menlo, monospace; padding: 6px 9px; border-radius: 4px; border: 1px solid currentColor; }
  .choice { font-weight: 600; }
  .src { font: 13px/1.45 ui-monospace, Menlo, monospace; color: var(--muted); }
  ul.limits, ol.refs { margin: 0; padding-left: 20px; display: flex; flex-direction: column; gap: 6px; }
  ol.refs { font-size: 14px; color: var(--muted); }
</style>
</head>
<body>
<main class="wrap">
  <header>
    <p class="eyebrow">Estimación orientativa</p>
    <h1>¿Cuántos años voy a vivir?</h1>
    <p class="muted">Cinco preguntas sobre hábitos con efecto medido en estudios de gran tamaño. El resultado es una media para personas con tu perfil, no un pronóstico individual. Cada ajuste se justifica más abajo con su fuente.</p>
  </header>

  <?php if ($errores): ?>
    <div class="errores" role="alert">
      <ul>
        <?php foreach ($errores as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= h(strtok($_SERVER['REQUEST_URI'] ?? '', '?') ?: '') ?>#resultado">
    <fieldset>
      <legend><span class="qtag">Punto de partida</span>Esperanza de vida de tu población</legend>
      <p class="help">Años de vida al nacer de la población de referencia. Para España ronda los 83. Cámbialo si quieres usar otro dato, por ejemplo el de tu sexo.</p>
      <div class="fields">
        <label class="field" for="base"><span>Años</span>
          <input id="base" name="base" type="text" inputmode="decimal" value="<?= h($valores['base']) ?>">
        </label>
      </div>
    </fieldset>

    <?php $n = 0; foreach ($preguntas as $id => $p): $n++; ?>
      <fieldset>
        <legend><span class="qtag">Pregunta <?= $n ?> de 5</span><?= h($p['texto']) ?></legend>
        <p class="help"><?= h($p['ayuda']) ?></p>
        <div class="opts">
          <?php foreach ($p['opciones'] as $clave => $o): ?>
            <label class="opt" for="<?= h($id . '-' . $clave) ?>">
              <input type="radio" id="<?= h($id . '-' . $clave) ?>" name="<?= h($id) ?>" value="<?= h($clave) ?>"<?= marcado($valores, $id, $clave) ?>>
              <span><?= h($o[0]) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <?php if ($id === 'alcohol'): $n++; ?>
        <fieldset>
          <legend><span class="qtag">Pregunta <?= $n ?> de 5</span>¿Cuánto mides y cuánto pesas?</legend>
          <p class="help">Se calcula el índice de masa corporal (IMC): el peso en kilos dividido por la altura en metros al cuadrado.</p>
          <div class="fields">
            <label class="field" for="altura"><span>Altura (cm)</span>
              <input id="altura" name="altura" type="text" inputmode="numeric" value="<?= h($valores['altura']) ?>">
            </label>
            <label class="field" for="peso"><span>Peso (kg)</span>
              <input id="peso" name="peso" type="text" inputmode="decimal" value="<?= h($valores['peso']) ?>">
            </label>
          </div>
        </fieldset>
      <?php endif; ?>
    <?php endforeach; ?>

    <?php if (!$esEnvio): ?>
      <p class="help">Las respuestas marcadas son un ejemplo. Cámbialas por las tuyas y pulsa el botón.</p>
    <?php endif; ?>
    <button type="submit">Ver mi resultado</button>
  </form>

  <?php if ($esEnvio && $total !== null): ?>
    <section class="result" id="resultado">
      <div>
        <p class="eyebrow">Tu estimación</p>
        <div class="big"><strong><?= h(fmt($total)) ?></strong><span>años</span></div>
        <p class="breakdown">Punto de partida <?= h(fmt($base)) ?> <?= h(sgn($suma)) ?> por tus hábitos</p>
      </div>

      <div>
        <h2>Qué suma y qué resta cada hábito</h2>
        <div class="bars">
          <?php foreach ($filas as $f):
              $clase = $f['delta'] > 0 ? 'gain' : ($f['delta'] < 0 ? 'loss' : '');
              $ancho = min(abs($f['delta']) / 10, 1) * 50; ?>
            <div class="barrow">
              <span class="name"><?= h($f['nombre']) ?></span>
              <span class="val <?= $clase ?>"><?= h(sgn($f['delta'])) ?> años</span>
              <div class="track"><?php if ($clase): ?><div class="fill <?= $clase ?>" style="width: <?= round($ancho, 2) ?>%"></div><?php endif; ?></div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="scale" aria-hidden="true"><span>−10 años</span><span>0</span><span>+10 años</span></div>
      </div>

      <div class="lever">
        <?php if ($peor['delta'] <= -1): ?>
          <strong>Lo que más te resta es <?= h(mb_strtolower($peor['nombre'])) ?> (<?= h(sgn($peor['delta'])) ?> años).</strong>
          <?= h($peor['consejo'] !== '' ? $peor['consejo'] : 'Es el factor con más margen de mejora en tu perfil.') ?>
        <?php else: ?>
          <strong>Ninguno de tus hábitos resta más de un año.</strong> Con este perfil, mantenerlo en el tiempo es lo que más cuenta.
        <?php endif; ?>
      </div>
    </section>

    <section>
      <h2>Por qué cada ajuste</h2>
      <div class="why">
        <?php foreach ($filas as $f):
            $clase = $f['delta'] > 0 ? 'gain' : ($f['delta'] < 0 ? 'loss' : 'zero'); ?>
          <article class="factor">
            <header><h3><?= h($f['nombre']) ?></h3><span class="chip <?= $clase ?>"><?= h(sgn($f['delta'])) ?> años</span></header>
            <p class="choice"><?= h($f['eleccion']) ?></p>
            <p><?= h($f['porque']) ?></p>
            <p class="src">Fuente: <?= h($f['fuente']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <section>
    <h2>Lo que esta estimación no recoge</h2>
    <ul class="limits">
      <li>La media de un grupo no dice nada seguro sobre una persona. Entre quienes tienen los mismos hábitos, la edad de fallecimiento varía en una decena de años o más.</li>
      <li>Los efectos se suman de forma simplificada. En la realidad se solapan: el sobrepeso, la dieta y el sedentarismo comparten parte de su riesgo.</li>
      <li>Quedan fuera la genética, el sueño, las relaciones sociales, el nivel de renta, la tensión arterial, el colesterol y el acceso a la atención médica. Tampoco se tiene en cuenta tu edad actual: quien ya ha cumplido 50 años tiene una esperanza de vida restante algo mayor que la de partida.</li>
      <li>Los estudios son observacionales o modelos estadísticos. Muestran asociaciones fuertes y repetidas, pero no son una garantía.</li>
      <li>Es una herramienta informativa. Para decisiones sobre tu salud, consulta con tu médico.</li>
    </ul>
    <h3 style="margin-top:18px">Fuentes</h3>
    <ol class="refs">
      <?php foreach ($referencias as $r): ?><li><?= h($r) ?></li><?php endforeach; ?>
    </ol>
  </section>
</main>
</body>
</html>
