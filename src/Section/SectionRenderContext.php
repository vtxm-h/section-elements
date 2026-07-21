<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

final class SectionRenderContext
{
    private string $role;
    private bool $render;
    private string $sectionType;
    private string $reason;

    private function __construct(string $role, bool $render, string $sectionType = '', string $reason = '')
    {
        $this->role = $role;
        $this->render = $render;
        $this->sectionType = $sectionType;
        $this->reason = $reason;
    }

    public static function start(string $sectionType): self
    {
        return new self('start', true, $sectionType);
    }

    public static function area(): self
    {
        return new self('area', true, 'split');
    }

    public static function end(string $sectionType): self
    {
        return new self('end', true, $sectionType);
    }

    public static function invalid(string $role = '', string $reason = ''): self
    {
        return new self($role, false, '', $reason);
    }

    public function shouldRender(): bool
    {
        return $this->render;
    }

    public function getSectionType(): string
    {
        return $this->sectionType;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
