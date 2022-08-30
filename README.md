## Introduction
This project should allow user to play a tic-tac-toe via API calls
## Usage
### Available API endpoints:
API prefix is `/api/`
- `GET /` - Sending requests there should show existing match or create a new one if existing does not exists
```
{
    "board": [
        [
            "",
            "",
            ""
        ],
        [
            "",
            "",
            ""
        ],
        [
            "",
            "",
            ""
        ]
    ],
    "score": {
        "x": 0,
        "o": 0
    },
    "currentTurn": "x",
    "victory": ""
}
```
- `DELETE /` - Will clear board and score and return next player turn
```
{
    "currentTurn": "x"
}
```
- `POST /{:piece}` with a body payload of `{"x": int, "y": int}` - Will place a {:piece} on the board if it can be placed
- - - This Endpoint will do some validation to ensure correcnt user is making a move and if place he wants to use is not occupied
- - Status codes are:
- - - 200 - OK
- - - 406 - Wrong user turn
- - - 409 - Cell is occupied :(

```
{
    "board": [
        [
            "",
            "",
            ""
        ],
        [
            "",
            "",
            ""
        ],
        [
            "",
            "x",
            ""
        ]
    ],
    "score": {
        "x": 0,
        "o": 0
    },
    "currentTurn": "o",
    "victory": ""
}
```
- `POST /restart` - Will refresh the board, update the scores if there was a winner after a last move.
```
{
    "board": [
        [
            "",
            "",
            ""
        ],
        [
            "",
            "",
            ""
        ],
        [
            "",
            "",
            ""
        ]
    ],
    "score": {
        "x": 0,
        "o": 1
    },
    "currentTurn": "o",
    "victory": ""
}
```

## Testing
For local development I've used Docker
Docker repo: https://github.com/BohdanHApiko/docker-php81-fpm-mariadb-nginx-adminer


To execute test run `php artisan tests`
- Hopefully it will look something similar
```
   PASS  Tests\Unit\BoardServiceTest
  ✓ winning condition
  ✓ winning condition with data set #1
  ✓ winning condition with data set #2
  ✓ winning condition with data set #3
  ✓ not won condition
  ✓ not won condition with data set #1
  ✓ not won condition with data set #2
  ✓ not won condition with data set #3
  ✓ if board can be updated
  ✓ if throws exception when updated with incorrect data

   PASS  Tests\Feature\GameControllerTest
  ✓ get game request endpoint is accessible
  ✓ make sure json response has correct structure
  ✓ place piece success
  ✓ place piece success win condition
  ✓ place piece place already taken error
  ✓ place piece wrong turn error
  ✓ reset board and score calculation

  Tests:  17 passed
  Time:   0.28s
  ```