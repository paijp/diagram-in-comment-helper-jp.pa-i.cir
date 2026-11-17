# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Changed
- Add and fix comments.
- cir.php: add symbols placed by pin names on a 3x3 grid (op-amp, transistors, FETs, crystal, fuse, switches, relay contact, coils), each also rotated and mirrored.
- cir.php: add two-terminal parts '{z}' '{Z}' '{s}' '{S}' and the package 'dipzvr'.
- Regenerate cir.html: it now has a sample for each symbol.

## [0.0.4] - 2024-01-02
### Changed
- Add a syntax-diagram and samples to cir.php.
- Add an alternative command '[' ']' for '<' '>' to to avoid parsing it as an HTML tag in cir.php.
- Change README.md.

## [0.0.3] - 2023-12-24
### Changed
- Fix comments about diagram-in-comment in map32mx2-28.php.

## [0.0.2] - 2023-12-24
### Changed
- Change name: diagram-in-code -> diagram-in-comment.
- Change: '/*html' -> '/*jp.pa-i/html', '/*syntaxdiagram' -> '/*jp.pa-i/syntaxdiafram'.

## [0.0.1] - 2023-12-24
### Added 
- Create CHANGELOG.md
- Move files from paijp/diagram-in-comment repository.
