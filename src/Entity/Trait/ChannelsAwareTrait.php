<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;

trait ChannelsAwareTrait
{
    protected Collection $channels;

    public function initializeChannelsCollection(): void
    {
        $this->channels = new ArrayCollection();
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }
}
