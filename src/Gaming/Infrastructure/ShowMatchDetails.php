<?php

declare(strict_types=1);

namespace Fooscore\Gaming\Infrastructure;

use Fooscore\Gaming\CanShowMatchDetails;
use Fooscore\Gaming\Match\{
    Match, MatchId, MatchRepository
};
use RuntimeException;

final class ShowMatchDetails implements CanShowMatchDetails
{
    /**
     * @var string
     */
    private $dir;

    public function __construct(string $projectionDir)
    {
        $this->dir = $projectionDir;
    }

    public function showMatchDetails(MatchId $matchId): array
    {
        $details = @file_get_contents($this->dir.$matchId->value()->toString().'.json');

        if ($details === false) {
            throw new RuntimeException('Cannot read projection file.');
        }

        return json_decode($details, true);
    }
}
