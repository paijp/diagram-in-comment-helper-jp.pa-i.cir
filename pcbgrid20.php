<?php

/*

	diagram-in-comment https://github.com/paijp/diagram-in-comment
	
	Copyright (c) 2024 paijp

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

*/

/*jp.pa-i/syntaxdiagram
{(**
[x
(,
[y
{(l
|(t
|(r
|(b
|(u
|(d
}[length
(,
[left-width
(,
[right-width
|(**
[x
(,
[y
(qr
|[pinname
(
{(1
|(2
|(3
|(4
|(6
|(7
|(8
|(9
|((
|()
|{(2
|(4
|(6
|(8
}{(<
|({
}[label
{(>
|(}
r}
r}|{(#
|(/
}[comment
}
*/

/*jp.pa-i/html
<pre>
<h1>length, left-width, right-width</h1>
/*jp.pa-i.cir/pcbgrid20
** 3,3r7,0,0
A
B
C
D
*/

/*jp.pa-i/html
/*jp.pa-i.cir/pcbgrid20
** 3,3r7,2,0
A
B
C
D
*/

/*jp.pa-i/html
/*jp.pa-i.cir/pcbgrid20
** 3,3r7,0,2
A
B
C
D
*/

/*jp.pa-i/html
<h1>line</h1>
/*jp.pa-i.cir/pcbgrid20
** 3,3r7,0,0
A	22
B	223366
C	88(44)66
D
*/

/*jp.pa-i/html
<h1>parts</h1>
/*jp.pa-i.cir/pcbgrid20
** 3,3r7,0,0
A	22{104}22
B	22{10k}}22
C	26{K(A}}}66
D
*/

/*jp.pa-i/html
<h1>DIP</h1>
/*jp.pa-i.cir/pcbgrid20
** 3,8r1,0,0
1
2
3
4

*/

/*jp.pa-i/html
/*jp.pa-i.cir/pcbgrid20
** 6,5l4,3,0
5
6
7
8

*/

/*jp.pa-i/html
/*jp.pa-i.cir/pcbgrid20
** 3,8r1,0,0
1
2
3
4

** 6,5l4,3,0
5
6
7
8

*/

/*jp.pa-i/html
<h1>QR code</h1>
- $qrprefix in env.php and SHA1 of the file will be encoded.
- $qrwithdate in env.php is the format to print the date.
- Even years later you can still find the source code and no information is leaked.

/*jp.pa-i.cir/pcbgrid20
** 10,2qr

*/

/*jp.pa-i/html
<h1>sample</h1>
/*jp.pa-i.cir/pcbgrid20
** 10,2qr

** 3,6d1,0,0
MC
A0
A1
A2
A3
A4
A5
G
A7
A6
C0
C1
C1
C3

** 6,19u14,3,0
C4
C5
C6
C7
G
V	(7888)62<104>4477
B0
B1
B2
B3
B4
B5
B6
B7

** 7,3d5,0,0
MC
V	(38<10k>>444112)4122222
G	44<0>>22222221
PD	4
PC	4

*/

/*
** 3,2r5,0,0
MC	(22<10k>>6)1223
V	22<0>>222222233
G	224442222<0>>2222
PD	22<0>>2
PC	2222<0>>4

*/


/*jp.pa-i/html
</pre>
*/

$a = explode("/", @$argv[0]);
list($basename) = explode(".", @array_pop($a));
$basename = @array_pop($a)."/{$basename}";

include(dirname(@$argv[0])."/env.php");

$now = time();
@$qrprefix .= "";

$optionlist = array();
for (;;) {
	if (!preg_match('/^--(.*)/', @$argv[1], $a))
		break;
	$optionlist[$a[1]] = 1;
	array_shift($argv);
}

$s = stream_get_contents(STDIN);
if (($hash = @$argv[1]) == "")
	$hash = sha1($s);
@list(, $s) = explode("/*{$basename}", $s, 2);
list($contents) = explode("*/", $s, 2);

$g0 = imagecreate($w = 720, $h = 450);
$c0 = imagecolorresolve($g0, 192, 255, 255);
$c1 = imagecolorresolve($g0, 0, 0, 0);
$c2 = imagecolorresolve($g0, 255, 0, 0);
imagefilledrectangle($g0, 0, 0, imagesx($g0), imagesy($g0), $c0);

for ($x=0; $x<$w; $x+=30)
	for ($y=0; $y<$h; $y+=30) {
		imagesetpixel($g0, $x, $y, $c2);
		imagesetpixel($g0, $x + 1, $y, $c2);
		imagesetpixel($g0, $x, $y + 1, $c2);
		imagesetpixel($g0, $x + 1, $y + 1, $c2);
	}


$strlist = array();
$struplist = array();
$eraselist = array();

$px = $py = $vx = $vy = 0;
foreach (preg_split("/\r\n|\r|\n/", $contents) as $line) {
#	$line = trim($line);
	if (preg_match('!^/!', $line))
		continue;
	if (preg_match('/^#/', $line))
		continue;
	list($line) = explode("#", $line, 2);
	if ((preg_match('/^[*][*][ \t]*([0-9]+),([0-9]+)([ltrbud])([0-9]+),([0-9]+),([0-9]+)/', $line, $a))) {
		$px = $l = $r = (int)$a[2] * 30;
		$py = $t = $b = (14 - (int)$a[1]) * 30;
		$vx = $vy = 0;
		switch ($a[3]) {
			case	'l':
				$b += ((int)$a[4] - 1) * 30;
				$r += (int)$a[5] * 30;
				$l -= (int)$a[6] * 30;
				$vy = 30;
				break;
			case	't':
			case	'u':
				$l -= ((int)$a[4] - 1) * 30;
				$b += (int)$a[5] * 30;
				$t -= (int)$a[6] * 30;
				$vx = -30;
				break;
			case	'r':
				$t -= ((int)$a[4] - 1) * 30;
				$l -= (int)$a[5] * 30;
				$r += (int)$a[6] * 30;
				$vy = -30;
				break;
			case	'b':
			case	'd':
				$r += ((int)$a[4] - 1) * 30;
				$t -= (int)$a[5] * 30;
				$b += (int)$a[6] * 30;
				$vx = 30;
				break;
		}
		$l -= 15;
		$t -= 15;
		$r += 15;
		$b += 15;
		imagesetthickness($g0, 2);
#		imagerectangle($g0, $l, $t, $r, $b, $c2);
		imagefilledrectangle($g0, $l, $t, $r, $t + 1, $c2);
		imagefilledrectangle($g0, $l, $b, $r, $b + 1, $c2);
		imagefilledrectangle($g0, $l, $t, $l + 1, $b, $c2);
		imagefilledrectangle($g0, $r, $t, $r + 1, $b, $c2);
		continue;
	}
	if ((preg_match('/^[*][*][ \t]*([0-9]+),([0-9]+)qr/', $line, $a))) {
		$x = (int)$a[2] * 30;
		$y = (14 - (int)$a[1]) * 30;
		
		imagestringup($g0, 5, $x, $y, @$argv[2], $c1);
		if (@$qrwithdate != "")
			imagestringup($g0, 5, $x += 12, $y, date($qrwithdate, $now), $c1);
		imagestringup($g0, 5, $x += 12, $y, substr($hash, 0, 7), $c1);
		$x += 16;
		
		if (@$qrpath === null)
			continue;
		
		foreach (explode("\n", shell_exec($qrpath." ".escapeshellarg(@$qrprefix.$hash))) as $y0 => $line)
			for ($x0=0; $x0<strlen($line); $x0++)
				imagefilledrectangle($g0, $x + $y0 * 2, $y - $x0 * 2, $x + $y0 * 2 + 1, $y - $x0 * 2 - 1, ((int)substr($line, $x0, 1))? $c1 : $c0);
		
		continue;
	}
	
	$a = preg_split("/[ \t]+/", $line, 2);
	$w2 = strlen($a[0]) * 4;
	if (($vx))
		$strlist[] = array($px - $w2, $py - 8, $a[0], $c1);
	else
		$struplist[] = array($px - 8, $py + $w2, $a[0], $c1);
	
	$s = trim(@$a[1]);
	
	$x = $px;
	$y = $py;
	$lastdir = "";
	$stack = array();
	while ($s != "") {
		$c = substr($s, 0, 1);
		$s = substr($s, 1);
		if (($c == "<")||($c == "{")) {
			preg_match('/^([^>}]*)([>}]*)(.*)/', $s, $a);
			$s = $a[3];
			
			imagesetthickness($g0, 2);
			$v = strlen($a[2]) * 30;
			$ex = $sx = $x;
			$ey = $sy = $y;
			$wx = $wy = 0;
			switch ($lastdir) {
				default:
					continue 2;
				case	'4':
					$ey += ($wy = $v) - 30;
					$sy -= 30;
					$t = $sy + 8;
					$b = $ey - 8;
					$l = $sx - 8;
					$r = $sx + 8;
					imageline($g0, $sx, $sy, $l, $t, $c1);
					imageline($g0, $l, $t, $l, $b, $c1);
					imageline($g0, $l, $b, $ex, $ey, $c1);
					imageline($g0, $sx, $sy, $r, $t, $c1);
					imageline($g0, $r, $t, $r, $b, $c1);
					imageline($g0, $r, $b, $ex, $ey, $c1);
					break;
				case	'8':
					$ex += ($wx = -$v) + 30;
					$sx += 30;
					$t = $sy - 8;
					$b = $sy + 8;
					$l = $ex + 8;
					$r = $sx - 8;
					imageline($g0, $sx, $sy, $r, $t, $c1);
					imageline($g0, $r, $t, $l, $t, $c1);
					imageline($g0, $l, $t, $ex, $ey, $c1);
					imageline($g0, $sx, $sy, $r, $b, $c1);
					imageline($g0, $r, $b, $l, $b, $c1);
					imageline($g0, $l, $b, $ex, $ey, $c1);
					break;
				case	'6':
					$ey += ($wy = -$v) + 30;
					$sy += 30;
					$t = $ey + 8;
					$b = $sy - 8;
					$l = $sx - 8;
					$r = $sx + 8;
					imageline($g0, $sx, $sy, $l, $b, $c1);
					imageline($g0, $l, $b, $l, $t, $c1);
					imageline($g0, $l, $t, $ex, $ey, $c1);
					imageline($g0, $sx, $sy, $r, $b, $c1);
					imageline($g0, $r, $b, $r, $t, $c1);
					imageline($g0, $r, $t, $ex, $ey, $c1);
					break;
				case	'2':
					$ex += ($wx = $v) - 30;
					$sx -= 30;
					$t = $sy - 8;
					$b = $sy + 8;
					$l = $sx + 8;
					$r = $ex - 8;
					imageline($g0, $sx, $sy, $l, $t, $c1);
					imageline($g0, $l, $t, $r, $t, $c1);
					imageline($g0, $r, $t, $ex, $ey, $c1);
					imageline($g0, $sx, $sy, $l, $b, $c1);
					imageline($g0, $l, $b, $r, $b, $c1);
					imageline($g0, $r, $b, $ex, $ey, $c1);
					break;
			}
			$eraselist[] = array($sx, $sy, $ex, $ey);
			$w2 = strlen($s0 = trim($a[1])) * 4;
			if (($wx))
				$strlist[] = array($sx - $w2 + $wx / 2, $sy - 8, $s0, $c1);
			else
				$struplist[] = array($sx - 8, $sy + $w2 + $wy / 2, $s0, $c1);
			
			$x = $ex;
			$y = $ey;
			continue;
		}
		$x0 = $x;
		$y0 = $y;
		switch ($lastdir = $c) {
			default:
				continue 2;
			case	'(':
				array_unshift($stack, array($x, $y));
				continue 2;
			case	')':
				if (count($stack))
					list($x, $y) = array_shift($stack);
				continue 2;
			case	'1':
				$y += 30;
				$x += 30;
				break;
			case	'2':
				$x += 30;
				break;
			case	'3':
				$y -= 30;
				$x += 30;
				break;
			case	'4':
				$y += 30;
				break; 
			case	'6':
				$y -= 30;
				break; 
			case	'7':
				$y += 30;
				$x -= 30;
				break;
			case	'8':
				$x -= 30;
				break; 
			case	'9':
				$y -= 30;
				$x -= 30;
				break;
		}
		if ((substr($s, 0, 1) != "<")&&(substr($s, 0, 1) != "{")) {
			imagesetthickness($g0, 8);
			imageline($g0, $x0, $y0, $x, $y, $c2);
		}
	}
	
	$px += $vx;
	$py += $vy;
}


foreach ($strlist as $a)
	imagestring($g0, 5, $a[0], $a[1], $a[2], $a[3]);

foreach ($struplist as $a)
	imagestringup($g0, 5, $a[0], $a[1], $a[2], $a[3]);


if ((@$optionlist["ql800"])) {
/*jp.pa-i/html
<h1>raster data for QL-820(brother) 2-colors label.</h1>
<pre>
$ php pcbgrid20.php --ql800 &lt;input.c |nc 192.168.0.123 9100		# normal

$ php pcbgrid20.php --ql800 hash comment &lt;input.c |nc 192.168.0.123 9100		# with hash and comment(printed near the QR code).

$ php pcbgrid20.php --ql800 '' comment &lt;input.c |nc 192.168.0.123 9100		# with comment(printed near the QR code).
</pre>

<hr />
*/
	
	$out = str_repeat(chr(0), 200);
	$out .= chr(0x1b)."@";			/* init */
	$out .= chr(0x1b)."ia".chr(1);		/* raster mode */
	$out .= chr(0x1b)."iz".chr(0x86).chr(0xa).chr(62).chr(0).chr(0xa).chr(1).chr(0).chr(0).chr(0).chr(0);
	$out .= chr(0x1b)."iK".chr(9);		/* auto-cut, 2-colors */
	$out .= "M".chr(0);			/* raw */
	for ($y=0; $y<imagesy($g0); $y++) {
		$s0 = $s1 = "";
		$pixel0 = $pixel1 = 0;
		for ($x=imagesx($g0) - 1; $x>=0; $x--) {
			if (($c = imagecolorat($g0, $x, $y)) == $c1)
				$pixel0 |= 1 << ($x & 7);
			else if ($c == $c2)
				$pixel1 |= 1 << ($x & 7);
			
			if (($x & 7) == 0) {
				$s0 .= chr($pixel0);
				$s1 .= chr($pixel1);
				$pixel0 = $pixel1 = 0;
			}
		}
		$out .= "w".chr(1).chr(90).$s0.str_repeat(chr(0), 90 - strlen($s0));
		$out .= "w".chr(2).chr(90).$s1.str_repeat(chr(0), 90 - strlen($s1));
	}
	$out .= chr(0x1a);
	print $out;
	die();
}

#header("Content-Type: image/png");
#imagepng($g0);
imagepng($g0, $tmpfn = dirname(@$argv[0])."/tmp/".getmypid());
imagedestroy($g0);
print '<img src="data:image/png;base64,'.base64_encode(file_get_contents($tmpfn)).'">'."\n";
unlink($tmpfn);


