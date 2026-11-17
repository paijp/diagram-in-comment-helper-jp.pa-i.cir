<?php

/*

	diagram-in-comment https://github.com/paijp/diagram-in-comment
	
	Copyright (c) 2023-2025 paijp

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

*/


class	drawobject {
	var	$l, $t, $r, $b;
	function	draw($g, $offx = 0, $offy = 0) {
	}
}


class	dotobject extends drawobject {
	function	__construct($x, $y) {
		$this->l = $x - 1;
		$this->t = $y - 1;
		$this->r = $x + 1;
		$this->b = $y + 1;
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$l = $this->l + $offx;
		$t = $this->t + $offy;
		$r = $this->r + $offx;
		$b = $this->b + $offy;
		imagefilledrectangle($g, $l, $t, $r, $b, $c1);
	}
}


class	lineobject extends drawobject {
	var	$sx, $sy, $ex, $ey;
	function	__construct($sx, $sy, $ex, $ey) {
		$this->sx = $sx;
		$this->sy = $sy;
		$this->ex = $ex;
		$this->ey = $ey;
		$this->l = min($sx, $ex);
		$this->r = max($sx, $ex);
		$this->t = min($sy, $ey);
		$this->b = max($sy, $ey);
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c1 = imagecolorresolve($g, 0, 0, 0);
		imageline($g, $offx + $this->sx, $offy + $this->sy, $offx + $this->ex, $offy + $this->ey, $c1);
	}
}


class	rectobject extends drawobject {
	function	__construct($l, $t, $r, $b) {
		$this->l = min($l, $r);
		$this->t = min($t, $b);
		$this->r = max($l, $r);
		$this->b = max($t, $b);
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$l = $this->l + $offx;
		$t = $this->t + $offy;
		$r = $this->r + $offx;
		$b = $this->b + $offy;
		imagefilledrectangle($g, $l, $t, $r, $b, $c0);
		imagerectangle($g, $l, $t, $r, $b, $c1);
	}
}


class	rectfobject extends drawobject {
	function	__construct($l, $t, $r, $b) {
		$this->l = min($l, $r);
		$this->t = min($t, $b);
		$this->r = max($l, $r);
		$this->b = max($t, $b);
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$l = $this->l + $offx;
		$t = $this->t + $offy;
		$r = $this->r + $offx;
		$b = $this->b + $offy;
		imagefilledrectangle($g, $l, $t, $r, $b, $c1);
	}
}


class	ellipseobject extends drawobject {
	function	__construct($l, $t, $r, $b) {
		$this->l = min($l, $r);
		$this->t = min($t, $b);
		$this->r = max($l, $r);
		$this->b = max($t, $b);
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$l = $this->l + $offx;
		$t = $this->t + $offy;
		$r = $this->r + $offx;
		$b = $this->b + $offy;
		imagefilledellipse($g, ($l + $r) / 2, ($t + $b) / 2, $r - $l, $b - $t, $c0);
		imageellipse($g, ($l + $r) / 2, ($t + $b) / 2, $r - $l, $b - $t, $c1);
	}
}


class	triangleobject extends drawobject {
	var	$sx, $sy, $mx, $my, $ex, $ey;
	function	__construct($sx, $sy, $mx, $my, $ex, $ey) {
		$this->sx = $sx;
		$this->sy = $sy;
		$this->mx = $mx;
		$this->my = $my;
		$this->ex = $ex;
		$this->ey = $ey;
		$this->l = min($sx, $mx, $ex);
		$this->r = max($sx, $mx, $ex);
		$this->t = min($sy, $my, $ey);
		$this->b = max($sy, $my, $ey);
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$sx = $this->sx + $offx;
		$sy = $this->sy + $offy;
		$mx = $this->mx + $offx;
		$my = $this->my + $offy;
		$ex = $this->ex + $offx;
		$ey = $this->ey + $offy;
		$a = array($sx, $sy, $mx, $my, $ex, $ey);
		imagefilledpolygon($g, $a, count($a) / 2, $c0);
		imagepolygon($g, $a, count($a) / 2, $c1);
	}
}


class	boxobject extends drawobject {
	var	$rotate;
	
	function	__construct($l, $t, $r, $b, $rotate = 0) {
		$this->l = $l;
		$this->t = $t;
		$this->r = $r;
		$this->b = $b;
		$this->rotate = $rotate;
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$l = $this->l + $offx;
		$t = $this->t + $offy;
		$r = $this->r + $offx;
		$b = $this->b + $offy;
		switch ($this->rotate) {
			default:
				$a = array($l, $t, $l, $b - 8, $l + 8, $b, $r, $b, $r, $t);
				break;
			case	1:
				$a = array($l, $t, $l, $b, $r - 8, $b, $r, $b - 8, $r, $t);
				break;
			case	2:
				$a = array($l, $t, $l, $b, $r, $b, $r, $t + 8, $r - 8, $t);
				break;
			case	3:
				$a = array($l + 8, $t, $l, $t + 8, $l, $b, $l, $b, $r, $t);
				break;
		}
		imagefilledpolygon($g, $a, count($a) / 2, $c0);
		imagepolygon($g, $a, count($a) / 2, $c1);
	}
}


class	hexobject extends drawobject {
	var	$x, $y, $vx, $vy;
	var	$s;
	var	$color;
	function	__construct($x, $y, $vx, $vy, $s = "", $color = 0) {
		$this->x = $x;
		$this->y = $y;
		$this->vx = $vx;
		$this->vy = $vy;
		$this->s = $s;
		$this->color = $color;
		if (($vx)) {
			$this->l = min($x, $x + $vx);
			$this->r = max($x, $x + $vx);
			$this->t = $y - 6;
			$this->b = $y + 6;
		} else {
			$this->l = $x - 6;
			$this->r = $x + 6;
			$this->t = min($y, $y + $vy);
			$this->b = max($y, $y + $vy);
		}
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c0 = imagecolorresolve($g, 255, 255, 255);
		$c1 = imagecolorresolve($g, 0, 0, 0);
		$size = 3;
		$offc = 4;
		$offl = 0;
		if (($this->vx)) {
			$l = $this->l + $offx;
			$r = $this->r + $offx;
			$t = $this->t + $offy;
			$b = $this->b + $offy;
			$y = $this->y + $offy;
			$a = array($l, $y, $l + 3, $t, $r - 3, $t, $r, $y, $r - 3, $b, $l + 3, $b);
			if (($this->color)) {
				imagefilledpolygon($g, $a, count($a) / 2, $c1);
				imagestring($g, $size, $l + $offc, $t + $offl, $this->s, $c0);
			} else {
				imagefilledpolygon($g, $a, count($a) / 2, $c0);
				imagepolygon($g, $a, count($a) / 2, $c1);
				imagestring($g, $size, $l + $offc, $t + $offl, $this->s, $c1);
			}
		} else {
			$l = $this->l + $offx;
			$r = $this->r + $offx;
			$t = $this->t + $offy;
			$b = $this->b + $offy;
			$x = $this->x + $offx;
			$a = array($x, $t, $r, $t + 3, $r, $b - 3, $x, $b, $l, $b - 3, $l, $t + 3);
			if (($this->color)) {
				imagefilledpolygon($g, $a, count($a) / 2, $c1);
				imagestringup($g, $size, $l + $offl, $b - $offc, $this->s, $c0);
			} else {
				imagefilledpolygon($g, $a, count($a) / 2, $c0);
				imagepolygon($g, $a, count($a) / 2, $c1);
				imagestringup($g, $size, $l + $offl, $b - $offc, $this->s, $c1);
			}
		}
	}
}


class	stringobject extends drawobject {
	var	$s;
	function	__construct($x, $y, $s = "") {
		$this->l = $x;
		$this->t = $y;
		$this->s = $s;
		$this->r = $x + strlen($s) * 7;
		$this->b = $y + 11;
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c1 = imagecolorresolve($g, 0, 0, 0);
		imagestring($g, 3, $offx + $this->l, $offy + $this->t, $this->s, $c1);
	}
}


class	vstringobject extends drawobject {
	var	$s;
	function	__construct($x, $y, $s = "") {
		$this->l = $x;
		$this->t = $y;
		$this->s = $s;
		$this->r = $x + 11;
		$this->b = $y + strlen($s) * 7;
	}
	function	draw($g, $offx = 0, $offy = 0) {
		$c1 = imagecolorresolve($g, 0, 0, 0);
		imagestringup($g, 3, $offx + $this->l, $offy + $this->b, $this->s, $c1);
	}
}


$partsmaster = array();
class	parts {
	var	$key;
	var	$val;
	function	__construct($k, $v) {
		$this->key = array();
		for ($i=0; $i<9; $i++)
			$this->key[] = substr($k, $i, 1);
		$this->val = $v;
		
		$this->addme();
		$this->rotateme();
		$this->addme();
		$this->rotateme();
		$this->addme();
		$this->rotateme();
		$this->addme();
		$this->rotateme();
		$this->mirrorme();
		$this->addme();
		$this->rotateme();
		$this->addme();
		$this->rotateme();
		$this->addme();
		$this->rotateme();
		$this->addme();
	}
	function	rotateme() {
		list($k1, $k2, $k3, $k4, $k5, $k6, $k7, $k8, $k9) = $this->key;
		$this->key = array($k7, $k4, $k1, $k8, $k5, $k2, $k9, $k6, $k3);
		
		foreach ($this->val as $k => $v) {
			$i = 1;
			while ($i < count($v)) {
				$x = $v[$i];
				$y = $v[$i + 1];
				$v[$i++] = $y;
				$v[$i++] = -$x;
			}
			$this->val[$k] = $v;
		}
	}
	function	mirrorme() {
		list($k1, $k2, $k3, $k4, $k5, $k6, $k7, $k8, $k9) = $this->key;
		$this->key = array($k3, $k2, $k1, $k6, $k5, $k4, $k9, $k8, $k7);
		foreach ($this->val as $k => $v) {
			$i = 1;
			while ($i < count($v)) {
				$v[$i] = -$v[$i];
				$i += 2;
			}
			$this->val[$k] = $v;
		}
	}
	function	addme() {
		global	$partsmaster;
		
		$partsmaster[implode("", $this->key)] = $this->val;
	}
}
new parts(" X  Y    ", array(
	array("rect", -8, 12, 8, 4), 
	array("rectf", -8, 0, 8, 1), 
	array("rectf", -8, 15, 8, 16)
));
new parts(" C     A ", array(
	array("ellipse", -4, -20, 4, -12), 
	array("ellipse", -4, 12, 4, 20), 
	array("line", 2, 12, 12, -20)
));
new parts(" C  A    ", array(
	array("ellipse", -4, 12, 4, 20), 
	array("ellipse", -4, -4, 4, 4), 
	array("line", 2, 12, 12, -4)
));
new parts(" C    A B", array(
	array("ellipse", -20, -20, -12, -12), 
	array("ellipse", 12, -20, 20, -12), 
	array("ellipse", -4, 12, 4, 20), 
	array("line", 2, 12, 12, -20)
));
new parts("ACB      ", array(
	array("ellipse", -20, 12, -12, 20), 
	array("ellipse", -4, 12, 4, 20), 
	array("ellipse", 12, 12, 20, 20), 
	array("line", 1, 12, 8, -20), 
	array("line", -16, -20, -8, -16), 
	array("line", -8, -16, -16, -12), 
	array("line", -16, -12, -16, 12), 
	array("line", 16, -20, 8, -16), 
	array("line", 8, -16, 16, -12), 
	array("line", 16, -12, 16, 12)
));
new parts("NG   OPV ", array(
	array("triangle", -20, -24, 28, 0, -20, 24), 
	array("line", -16, -14, -12, -14), 
	array("line", -14, -16, -14, -12), 
	array("line", -16, 14, -12, 14)
));
new parts("  NB    C", array(
	array("ellipse", -10, -18, 26, 18), 
	array("rectf", -2, -12, 0, 12), 
	array("line", 16, -16, 0, 0), 
	array("line", 16, 16, 0, 0), 
	array("line", 16, 16, 10, 14), 
	array("line", 16, 16, 14, 10), 
	array("line", -16, 0, 0, 0)
));
new parts("  PB    C", array(
	array("ellipse", -10, -18, 26, 18), 
	array("rectf", -2, -12, 0, 12), 
	array("line", 16, -16, 0, 0), 
	array("line", 16, 16, 0, 0), 
	array("line", 2, 6, 0, 0), 
	array("line", 6, 2, 0, 0), 
	array("line", -16, 0, 0, 0)
));
new parts("  SP    D", array(
	array("ellipse", -10, -18, 26, 18), 
	array("rectf", 2, -12, 4, 12), 
	array("line", 16, -16, 16, -9), 
	array("line", 2, -9, 16, -9), 
	array("line", 16, 16, 16, 9), 
	array("line", 2, 9, 16, 9), 
	array("line", 2, 0, -4, -2), 
	array("line", 2, 0, -4, 2), 
	array("line", -16, 0, 2, 0)
));
new parts("  SN    D", array(
	array("ellipse", -10, -18, 26, 18), 
	array("rectf", 2, -12, 4, 12), 
	array("line", 16, -16, 16, -9), 
	array("line", 2, -9, 16, -9), 
	array("line", 16, 16, 16, 9), 
	array("line", 2, 9, 16, 9), 
	array("line", -10, 0, -4, -2), 
	array("line", -10, 0, -4, 2), 
	array("line", -16, 0, 2, 0)
));
new parts("G N     D", array(
	array("ellipse", -12, -18, 24, 18), 
	array("rectf", 4, -18, 6, -10), 
	array("rectf", 4, -4, 6, 4), 
	array("rectf", 4, 10, 6, 18), 
	array("line", 6, -15, 16, -15), 
	array("line", 6, 0, 16, 0), 
	array("line", 16, 0, 16, 16), 
	array("line", 6, 15, 16, 15), 
	array("line", 6, 0, 12, -2), 
	array("line", 6, 0, 12, 2), 
	array("line", -16, 16, -3, 16), 
	array("line", -3, -12, -3, 16)
));
new parts("  N   G D", array(
	array("ellipse", -12, -18, 24, 18), 
	array("rectf", 4, -18, 6, -10), 
	array("rectf", 4, -4, 6, 4), 
	array("rectf", 4, 10, 6, 18), 
	array("line", 6, -15, 16, -15), 
	array("line", 6, 0, 16, 0), 
	array("line", 16, 0, 16, 16), 
	array("line", 6, 15, 16, 15), 
	array("line", 6, 0, 12, -2), 
	array("line", 6, 0, 12, 2), 
	array("line", -16, -16, -3, -16), 
	array("line", -3, -16, -3, 12)
));
new parts("G P     D", array(
	array("ellipse", -12, -18, 24, 18), 
	array("rectf", 4, -18, 6, -10), 
	array("rectf", 4, -4, 6, 4), 
	array("rectf", 4, 10, 6, 18), 
	array("line", 6, -15, 16, -15), 
	array("line", 6, 0, 16, 0), 
	array("line", 16, 0, 16, 16), 
	array("line", 6, 15, 16, 15), 
	array("line", 16, 0, 10, -2), 
	array("line", 16, 0, 10, 2), 
	array("line", -16, 16, -3, 16), 
	array("line", -3, -12, -3, 16)
));
new parts("  P   G D", array(
	array("ellipse", -12, -18, 24, 18), 
	array("rectf", 4, -18, 6, -10), 
	array("rectf", 4, -4, 6, 4), 
	array("rectf", 4, 10, 6, 18), 
	array("line", 6, -15, 16, -15), 
	array("line", 6, 0, 16, 0), 
	array("line", 16, 0, 16, 16), 
	array("line", 6, 15, 16, 15), 
	array("line", 16, 0, 10, -2), 
	array("line", 16, 0, 10, 2), 
	array("line", -16, -16, -3, -16), 
	array("line", -3, -16, -3, 12)
));
new parts("L MB  A  ", array(
	array("ellipse", -20, 12, -12, 20), 
	array("ellipse", 12, 12, 20, 20), 
	array("line", -18, 12, -18, 0), 
	array("line", -18, 0, -15, -3), 
	array("line", -15, -3, -12, -3), 
	array("line", -12, -3, -6, 3), 
	array("line", -6, 3, -6, 9), 
	array("line", -6, 9, -9, 12), 
	array("line", -9, 12, -12, 9), 
	array("line", -12, 9, -12, 3), 
	array("line", -12, 3, -6, -3), 
	array("line", -6, -3, -3, -3), 
	array("line", -3, -3, 3, 3), 
	array("line", 3, 3, 3, 9), 
	array("line", 3, 9, 0, 12), 
	array("line", 0, 12, -3, 9), 
	array("line", -3, 9, -3, 3), 
	array("line", -3, 3, 3, -3), 
	array("line", 3, -3, 6, -3), 
	array("line", 6, -3, 12, 3), 
	array("line", 12, 3, 12, 9), 
	array("line", 12, 9, 9, 12), 
	array("line", 9, 12, 6, 9), 
	array("line", 6, 9, 6, 3), 
	array("line", 6, 3, 12, -3), 
	array("line", 12, -3, 15, -3), 
	array("line", 15, -3, 18, 0), 
	array("line", 18, 0, 18, 12), 
	array("line", -24, -6, 24, -6), 
	array("line", -24, -10, 24, -10)
));
new parts("LMNB  A  ", array(
	array("ellipse", -20, 12, -12, 20), 
	array("ellipse", -4, 12, 4, 20), 
	array("ellipse", 12, 12, 20, 20), 
	array("line", -18, 12, -18, 0), 
	array("line", -18, 0, -15, -3), 
	array("line", -15, -3, -12, -3), 
	array("line", -12, -3, -6, 3), 
	array("line", -6, 3, -6, 9), 
	array("line", -6, 9, -9, 12), 
	array("line", -9, 12, -12, 9), 
	array("line", -12, 9, -12, 3), 
	array("line", -12, 3, -6, -3), 
	array("line", -6, -3, -3, -3), 
	array("line", -3, -3, 3, 3), 
	array("line", 3, 3, 3, 9), 
	array("line", 3, 9, 0, 12), 
	array("line", 0, 12, -3, 9), 
	array("line", -3, 9, -3, 3), 
	array("line", -3, 3, 3, -3), 
	array("line", 3, -3, 6, -3), 
	array("line", 6, -3, 12, 3), 
	array("line", 12, 3, 12, 9), 
	array("line", 12, 9, 9, 12), 
	array("line", 9, 12, 6, 9), 
	array("line", 6, 9, 6, 3), 
	array("line", 6, 3, 12, -3), 
	array("line", 12, -3, 15, -3), 
	array("line", 15, -3, 18, 0), 
	array("line", 18, 0, 18, 12), 
	array("line", -24, -6, 24, -6), 
	array("line", -24, -10, 24, -10)
));
new parts("CLMB  A  ", array(
	array("ellipse", -4, 12, 4, 20), 
	array("ellipse", 12, 12, 20, 20), 
	array("line", 0, 12, 0, 0), 
	array("line", 0, 0, 4, -4), 
	array("line", 4, -4, 6, -4), 
	array("line", 6, -4, 12, 2), 
	array("line", 12, 2, 12, 8), 
	array("line", 12, 8, 8, 12), 
	array("line", 8, 12, 4, 8), 
	array("line", 4, 8, 4, 2), 
	array("line", 4, 2, 10, -4), 
	array("line", 10, -4, 12, -4), 
	array("line", 12, -4, 16, 0), 
	array("line", 16, 0, 16, 12), 
	array("line", -8, -6, 24, -6), 
	array("line", -8, -10, 24, -10)
));
new parts("   F G   ", array(
	array("ellipse", -20, -4, -12, 4), 
	array("ellipse", 12, -4, 20, 4), 
	array("line", -12, 0, -8, -4), 
	array("line", -8, -4, -4, -4), 
	array("line", -4, -4, 4, 4), 
	array("line", 4, 4, 8, 4), 
	array("line", 8, 4, 12, 0)
));
new parts("K E   A C", array(
	array("line", -16, -16, -16, -4), 
	array("line", -20, -4, -12, -4), 
	array("line", -20, -4, -16, 4), 
	array("line", -12, -4, -16, 4), 
	array("line", -20, 4, -12, 4), 
	array("line", -16, 4, -16, 16), 
	array("line", 16, -16, 16, -8), 
	array("line", 16, -8, 8, 0), 
	array("line", 8, 0, 16, 8), 
	array("line", 16, 8, 16, 16), 
	array("line", 8, -8, 8, 8), 
	array("line", 16, 8, 16, 4), 
	array("line", 16, 8, 12, 8), 
	array("line", -12, 0, -4, -2), 
	array("line", -4, -2, -8, 2), 
	array("line", -8, 2, 4, 0), 
	array("line", 0, -2, 4, 0), 
	array("line", 0, 2, 4, 0)
));
new parts(" W C   V ", array(
	array("line", 0, 16, 6, 12), 
	array("line", 6, 12, -6, 6), 
	array("line", -6, 6, 6, 0), 
	array("line", 6, 0, -6, -6), 
	array("line", -6, -6, 6, -12), 
	array("line", 6, -12, 0, -16), 
	array("line", -16, 0, -6, 0), 
	array("line", -12, 4, -6, 0), 
	array("line", -12, -4, -6, 0)
));
new parts(" V C W X ", array(
	array("line", 0, 16, 6, 12), 
	array("line", 6, 12, -6, 6), 
	array("line", -6, 6, 6, 0), 
	array("line", 6, 0, -6, -6), 
	array("line", -6, -6, 6, -12), 
	array("line", 6, -12, 0, -16), 
	array("line", -16, 0, -6, 0), 
	array("line", -12, 4, -6, 0), 
	array("line", -12, -4, -6, 0), 
	array("rectf", 5, -1, 7, 1), 
	array("line", 6, 0, 16, 0)
));


$fglist = array();
$midlist = array();
$bglist = array();
$poslist = array();
foreach (preg_split("/\r\n|\r|\n/", stream_get_contents(STDIN)) as $line) {
	list($line) = explode("#", $line, 2);
	$line = trim($line);
	
/*jp.pa-i/html
<p><a href="https://github.com/paijp/diagram-in-comment">How to generate this?</a></p>
*/
/* generated HTML: https://paijp.github.io/diagram-in-comment-helper-jp.pa-i.cir/cir.html */

/*jp.pa-i/syntaxdiagram
{(/*jp.pa-i.cir/cir
( 
{(sip
|(dip
|(dipzv
|(qfp
}[num
{|(
[name
}
|{|(2
|(4
|(6
|(8
|((
|()
|(<
[name
(>
|(<<
[name
(>
|([
[name
(]
|([[
[name
(]
|({c
[name
(}
|({r
[name
(}
|({d
[name
(}
|({D
[name
(}
|({
{(1
|(2
|(3
|(4
|(5
|(6
|(7
|(8
|(9
}
[pinname
{|{(1
|(2
|(3
|(4
|(5
|(6
|(7
|(8
|(9
}
[pinname
}
{|{(1
|(3
|(5
|(7
|(9
}[pinname
r}
|[pinname
|(}
r}}{|(#
{|[comment
}}
*/
	if (preg_match('!/[*][^ \t]+[ \t]+([-_A-Za-z]+)([0-9]+)(.*)!', $line, $a)) {
		$num = (int)$a[2];
		$par = trim($a[3]);
		$fglist = array();
		$midlist = array();
		$bglist = array();
		$poslist = array();
		switch ($a[1]) {
			case	"sip":
				$midlist[] = new boxobject(0, 0, 16 * $num, 16);
				$fglist[] = new stringobject(8, 4, $par);
				for ($i=0; $i<$num; $i++)
					$poslist[] = array(8 + 16 * $i, 8);
				break;
			case	"dip":
				$midlist[] = new boxobject(0, 0, 8 * $num, 48);
				$fglist[] = new stringobject(8, 18, $par);
				for ($i=0; $i<$num; $i+=2)
					$poslist[] = array(8 + 8 * $i, 40);
				while (($i -= 2) >= 0)
					$poslist[] = array(8 + 8 * $i, 8);
				break;
			case	"dipzv":
				$midlist[] = new boxobject(0, 0, 32, 8 * $num);
				$fglist[] = new vstringobject(12, 8 * $num - 16 - strlen($par) * 7, $par);
				for ($i=0; $i<$num; $i+=2) {
					$poslist[] = array(8, 8 * ($num - $i) - 8);
					$poslist[] = array(24, 8 * ($num - $i) - 8);
				}
				break;
			case	"dipzvr":
				$midlist[] = new boxobject(0, 0, 32, 8 * $num, 2);
				$fglist[] = new vstringobject(12, 8 * $num - 16 - strlen($par) * 7, $par);
				for ($i=0; $i<$num; $i+=2) {
					$poslist[] = array(24, 8 * $i + 8);
					$poslist[] = array(8, 8 * $i + 8);
				}
				break;
			case	"qfp":
				$midlist[] = new boxobject(0, 0, $w = 4 * $num, $h = 4 * $num);
				$fglist[] = new stringobject(8, 4 * $num - 24, $par);
				for ($i=0; $i<$num/4; $i++)
					$poslist[] = array(8 + 16 * $i, $h - 8);
				for ($i=0; $i<$num/4; $i++)
					$poslist[] = array($w - 8, $h - 8 - 16 * $i);
				for ($i=0; $i<$num/4; $i++)
					$poslist[] = array($w - 8 - 16 * $i, 8);
				for ($i=0; $i<$num/4; $i++)
					$poslist[] = array(8, 8 + 16 * $i);
				break;
		}
		continue;
	}
	if ($line == "*/") {
		if (count($midlist) == 0)
			continue;
		$l = $t = $r = $b = null;
		foreach (array($bglist, $midlist, $fglist) as $list)
			foreach ($list as $obj) {
				if ($l === null) {
					$l = $obj->l;
					$r = $obj->r;
					$t = $obj->t;
					$b = $obj->b;
				}
				$l = min($l, $obj->l);
				$r = max($r, $obj->r);
				$t = min($t, $obj->t);
				$b = max($b, $obj->b);
			}
		$g0 = imagecreate($w = $r - $l + 32, $h = $b - $t + 32);
#		$c0 = imagecolorresolve($g0, 255, 255, 255);
		$c0 = imagecolorresolve($g0, 224, 224, 224);
		imagefilledrectangle($g0, 0, 0, $w, $h, $c0);
		foreach (array($bglist, $midlist, $fglist) as $list)
			foreach ($list as $obj)
				$obj->draw($g0, 16 - $l, 16 - $t);
#		header("Content-Type: image/png");
		imagepng($g0, $tmpfn = dirname(@$argv[0])."/tmp/".getmypid());
		imagedestroy($g0);
		print '<img src="data:image/png;base64,'.base64_encode(file_get_contents($tmpfn)).'">'."\n";
		unlink($tmpfn);
		die();
	}
	if (count($midlist) == 0)
		continue;
	if (count($poslist) == 0)
		continue;
	list($x, $y) = array_shift($poslist);
	$vx = $vy = 0;
	$stack = array();
	$posnamestack = array();
	while (($c = substr($line, 0, 1)) != "") {
		$line = substr($line, 1);
		$x0 = $x;
		$y0 = $y;
		switch ($c) {
			default:
				if (($a = @$posnamestack[0][$c]) !== null)
					list($x, $y) = $a;
				continue 2;
			case	"2":
				$bglist[] = new lineobject($x0, $y0, $x += ($vx = 0) * 16, $y += ($vy = 1) * 16);
				continue 2;
			case	"4":
				$bglist[] = new lineobject($x0, $y0, $x += ($vx = -1) * 16, $y += ($vy = 0) * 16);
				continue 2;
			case	"6":
				$bglist[] = new lineobject($x0, $y0, $x += ($vx = 1) * 16, $y += ($vy = 0) * 16);
				continue 2;
			case	"8":
				$bglist[] = new lineobject($x0, $y0, $x += ($vx = 0) * 16, $y += ($vy = -1) * 16);
				continue 2;
			case	"(":
				$bglist[] = new dotobject($x, $y);
				$stack[] = array($x, $y, $vx, $vy);
				continue 2;
			case	")":
				if (count($stack) > 0)
					list($x, $y, $vx, $vy) = array_pop($stack);
				continue 2;
			case	"<":
				list($s, $line) = explode(">", $line, 2);
				$color = 0;
				if (substr($s, 0, 1) == "<") {
					$color = 1;
					$s = substr($s, 1);
				}
				$len = 64;
				$midlist[] = new hexobject($x0, $y0, $vx * $len, $vy * $len, $s, $color);
				$x += $vx * $len;
				$y += $vy * $len;
				continue 2;
			case	"[":
				list($s, $line) = explode("]", $line, 2);
				$color = 0;
				if (substr($s, 0, 1) == "[") {
					$color = 1;
					$s = substr($s, 1);
				}
				$len = 64;
				$midlist[] = new hexobject($x0, $y0, $vx * $len, $vy * $len, $s, $color);
				$x += $vx * $len;
				$y += $vy * $len;
				continue 2;
			case	"}":
				array_shift($posnamestack);
				continue 2;
			case	"{":
				$c = substr($line, 0, 1);
				
				if ((int)$c >= 1) {
					$x -= (($c - 1) % 3) * 16 - 16;
					$y += (int)floor(($c - 1) / 3) * 16 - 16;
					$key = array();
					$count = 0;
					$lastname = "";
					for (;;) {
						$c = (int)substr($line, 0, 1);
						if ($c < 1)
							break;
						if (($count >= 2)&&(($c & 1) == 0))
							break;
						$key[$c] = $lastname = substr($line, 1, 1);
						$line = substr($line, 2);
						$count++;
					}
					$line = $lastname.$line;
					foreach ($partsmaster as $k => $v) {
						foreach ($key as $k0 => $v0)
							if (substr($k, $k0 - 1, 1) != $v0)
								continue 2;
						$a = array();
						for ($i=0; $i<9; $i++) {
							if (($c = substr($k, $i, 1)) == " ")
								continue;
							if ($c == "")
								continue;
							$x0 = $x - 16 + ($i % 3) * 16;
							$y0 = $y + 16 - (int)floor($i / 3) * 16;
							$a[$c] = array($x0, $y0);
						}
						array_unshift($posnamestack, $a);
						foreach ($v as $a)
							switch ($a[0]) {
								case	"line":
									$midlist[] = new lineobject($a[1] + $x, $a[2] + $y, $a[3] + $x, $a[4] + $y);
									break;
								case	"rect":
									$midlist[] = new rectobject($a[1] + $x, $a[2] + $y, $a[3] + $x, $a[4] + $y);
									break;
								case	"rectf":
									$midlist[] = new rectfobject($a[1] + $x, $a[2] + $y, $a[3] + $x, $a[4] + $y);
									break;
								case	"ellipse":
									$midlist[] = new ellipseobject($a[1] + $x, $a[2] + $y, $a[3] + $x, $a[4] + $y);
									break;
								case	"triangle":
									$midlist[] = new triangleobject($a[1] + $x, $a[2] + $y, $a[3] + $x, $a[4] + $y, $a[5] + $x, $a[6] + $y);
									break;
							}
						break;
					}
					continue 2;
				}
				list($s, $line) = explode("}", $line, 2);
				$s = substr($s, 1);
				
				if ($s == "")
					;
				else if (($vx))
					$fglist[] = new stringobject($x + $vx * 8 - 8, $y + 4, $s);
				else
					$fglist[] = new vstringobject($x + 4, $y + $vy * 8 - 8, $s);
				
				$list = array();
				switch ($c) {
					case	"r":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, 0, 6, -4);
						$list[] = array(6, -4, 10, 4);
						$list[] = array(10, 4, 12, 0);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"c":
						$list[] = array(0, 0, 6, 0);
						$list[] = array(6, -4, 6, 4);
						$list[] = array(10, -4, 10, 4);
						$list[] = array(10, 0, 16, 0);
						break;
					case	"d":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, -4, 12, 0);
						$list[] = array(4, 4, 12, 0);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"D":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, 0, 12, -4);
						$list[] = array(4, 0, 12, 4);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"z":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, -4, 12, 0);
						$list[] = array(4, 4, 12, 0);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, -4, 10, -4);
						$list[] = array(12, 4, 14, 4);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"Z":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, -4, 2, -4);
						$list[] = array(4, 4, 6, 4);
						$list[] = array(4, 0, 12, -4);
						$list[] = array(4, 0, 12, 4);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"s":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, -4, 12, 0);
						$list[] = array(4, 4, 12, 0);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, -4, 10, -4);
						$list[] = array(10, -2, 10, -4);
						$list[] = array(12, 4, 14, 4);
						$list[] = array(14, 2, 14, 4);
						$list[] = array(12, 0, 16, 0);
						break;
					case	"S":
						$list[] = array(0, 0, 4, 0);
						$list[] = array(4, -4, 4, 4);
						$list[] = array(4, -4, 2, -4);
						$list[] = array(2, -2, 2, -4);
						$list[] = array(4, 4, 6, 4);
						$list[] = array(6, 2, 6, 4);
						$list[] = array(4, 0, 12, -4);
						$list[] = array(4, 0, 12, 4);
						$list[] = array(12, -4, 12, 4);
						$list[] = array(12, 0, 16, 0);
						break;
				}
				$ex0 = $x;
				$ey0 = $y;
				foreach ($list as $a) {
					list($sx, $sy, $ex, $ey) = $a;
					$sx0 = $sx * $vx - $sy * $vy + $x;
					$sy0 = $sx * $vy + $sy * $vx + $y;
					$ex0 = $ex * $vx - $ey * $vy + $x;
					$ey0 = $ex * $vy + $ey * $vx + $y;
					$bglist[] = new lineobject($sx0, $sy0, $ex0, $ey0);
				}
				$x = $ex0;
				$y = $ey0;
				continue 2;
		}
	}
}


/*jp.pa-i/html
<pre>
<h1>direction</h1><p>same as tenkey.</p>
*/
/*jp.pa-i.cir/cir qfp12
24<<1>
2<<2>
26<<3>

66<<6>

86<<9>
8<<8>
84<<7>

44<<4>
*/


/*jp.pa-i/html
<h1>SIP</h1>
/*jp.pa-i.cir/cir sip3 U1
22(4[VOUT])2{c104}2[[G]
22(66[VIN])2{c104}2[[G]
22222[[G]
#<h1>&darr;</h1>
*/

/*jp.pa-i/html
<h1>DIP</h1>
/*jp.pa-i.cir/cir dip8 U2
22(4[OUTA])2{r10k}2(688888)2{r10k}2[[G]

22[INA]
22[[G]
88[INB]

888(4[OUTB])8{r10k}8(6222222)8{r10k}8[[G]
844(4[[V])2{c104}24[[G]
#<h1>&darr;</h1>
*/

/*jp.pa-i/html
<h1>QFP</h1>
/*jp.pa-i.cir/cir qfp20 U3
22{d}2{r150}2[[G]
22{D}2{r150}2[[V]

22[P4]2{r10k}2[[G]
22[P5]
66[P6]
66[P7]
66[P8]
66[P9]
66[P10]
88[P11]
88[P12]
88[P13]
88[P14]
88[P15]
44[P16]
44[P17]
44[P18]
44[P19]
44[P20]
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an opamp.</h1><p>7(left-top)=P, and 1(left-bottom)=N.</p>
/*jp.pa-i.cir/cir qfp4

6<<7=P>6{7P1N4<<1=N>V8<<8=V>G2<<2=G>O6<<6=O>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>rotate and mirror an opamp.</h1><p>7(left-top)=P, and 9(right-top)=N.</p>
/*jp.pa-i.cir/cir qfp4
2<<7=P>2{7P9N8<<9=N>V4<<4=V>G6<<6=G>O2<<2=O>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an Nch Tr.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=B>6{4B3N2<<3=N>C8<<9=C>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an Pch Tr.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=B>6{4B3P2<<3=P>C8<<9=C>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an Nch JFET.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=P>6{4P3S2<<3=S>D8<<9=D>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a Pch JFET.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=N>6{4N3S2<<3=S>D8<<9=D>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an Nch MOS-FET.</h1>
/*jp.pa-i.cir/cir qfp4

6<<1=G>6{1G3N2<<3=N>D8<<9=D>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of an Pch MOS-FET.</h1>
/*jp.pa-i.cir/cir qfp4

6<<1=G>6{1G3P2<<3=P>D8<<9=D>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a xtal.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=X>6{4X5Y6<<5=Y>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a fuse.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=F>6{4F6G6<<6=G>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a small switch.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C5A6<<5=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a switch.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C6A6<<6=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a bi-directional switch.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C9A6<<9=A>B6<<3=B>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a relay contact.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C7A4<<7=A>B4<<1=B>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a coil.</h1>
/*jp.pa-i.cir/cir qfp4

6<<7=L>6{7L1M4<<1=M>B8<<8=B>A8<<9=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a tapped coil.</h1>
/*jp.pa-i.cir/cir qfp4

6<<7=L>6{7L1N4<<1=N>M4<<4=M>B8<<8=B>A8<<9=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a half coil.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=L>6{4L1M4<<1=M>C8<<7=C>B8<<8=B>A8<<9=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>How to draw a relay(coil first).</h1>
/*jp.pa-i.cir/cir qfp4

6<<7=L>6{7L1M4<<1=M>A{7A8C8<<8=C>B8<<9=B>A8<<7=A>}}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>How to draw a relay(contact first).</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C7A4<<7=A>B4<<1=B>A{1A7L8<<7=L>M8<<9=M>}}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>How to draw a transformer.</h1>
/*jp.pa-i.cir/cir qfp4

6<<7=L>6{7L1M4<<1=M>A{8B6M6<<6=M>L6<<9=L>N6<<3=N>}}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>How to draw a transformer(multi).</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=L>6{4L1M4<1=M>C}{1M4L4<4=L>M4<1=M>C}{1M4L4<4=L>M4<1=M>A}{8B6L6<6=L>M6<3=M>M}{9C6L6<6=L>M6<3=M>M}{6L3M6<3=M>M}{6L3M6<3=M>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a photo coupler.</h1>
/*jp.pa-i.cir/cir qfp4

6<<1=K>6{1K3E6<<3=E>C6<<9=C>A4<<7=A>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a volume.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C8V8<<8=V>W2<<2=W>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
<h1>Pinname of a tapped volume.</h1>
/*jp.pa-i.cir/cir qfp4

6<<4=C>6{4C2X2<<2=X>V8<<8=V>W6<<6=W>}
#<h1>&darr;</h1>
*/


/*jp.pa-i/html
</pre>
*/


