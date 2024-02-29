<?php namespace App\Sport\Provider\PhoenixGambling\Market\Esport;

use App\Sport\Provider\PhoenixGambling\PhoenixGamblingEsportMarketHandler;
use App\Sport\Provider\SportGameSnapshot;
use App\Sport\Provider\SportMarketTranslation;
use Illuminate\Support\Facades\Log;

class MapWinnerTwoway extends PhoenixGamblingEsportMarketHandler {

  function isHandling(string $market, string $runner): bool {
    return str_starts_with($market, "Map") && str_ends_with($market, "winner - twoway");
  }

  function isWinner(string $runner, SportGameSnapshot $snapshot): string {
    $stats = $this->esport($snapshot->id());
    $period = $stats->periodScores()->match($this->extract($snapshot->market(), 'winner'));

    if($runner === $stats->game()->home && $period->isHome()) return $this->win();
    if($runner === $stats->game()->away && $period->isAway()) return $this->win();

    return $this->lose();
  }

  function translation(string $market, string $runner): SportMarketTranslation {
    return (new SportMarketTranslation())->runner($runner)->market('sport.market.esport.mapWinnerTwoway', ['map' => $this->extract($market, 'winner')]);
  }

}
