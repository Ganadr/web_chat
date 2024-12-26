<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caro Game with Alpha-Beta Pruning</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #343a40;
        }

        #game-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        #game-board {
            display: grid;
            grid-template-columns: repeat(3, 60px);
            grid-gap: 5px;
        }

        .cell {
            width: 60px;
            height: 60px;
            background-color: #e9ecef;
            border: 2px solid #ced4da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #495057;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .cell:hover:not(.taken) {
            background-color: #dee2e6;
            transform: scale(1.1);
        }

        .cell.taken {
            cursor: not-allowed;
        }

        #status {
            margin-top: 20px;
            font-size: 18px;
            color: #495057;
            transition: transform 0.5s, color 0.5s;
        }

        #status.victory {
            color: #28a745;
            transform: scale(1.2);
        }

        #status.defeat {
            color: #dc3545;
            transform: scale(1.2);
        }

        #status.draw {
            color: #6c757d;
            transform: scale(1.2);
        }

        #restart {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        #restart:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>Caro Game</h1>
    <div id="game-container">
        <div id="game-board"></div>
    </div>
    <p id="status"></p>
    <button id="restart" onclick="restartGame()">Restart</button>

    <script>
        const SIZE = 3;
        const EMPTY = '';
        const HUMAN = 'X';
        const AI = 'O';

        let board = Array(SIZE).fill(null).map(() => Array(SIZE).fill(EMPTY));

        const gameBoard = document.getElementById('game-board');
        const status = document.getElementById('status');

        function createBoard() {
            gameBoard.innerHTML = '';
            for (let i = 0; i < SIZE; i++) {
                for (let j = 0; j < SIZE; j++) {
                    const cell = document.createElement('div');
                    cell.classList.add('cell');
                    cell.dataset.row = i;
                    cell.dataset.col = j;
                    cell.addEventListener('click', handleHumanMove);
                    gameBoard.appendChild(cell);
                }
            }
        }

        function handleHumanMove(event) {
            const row = parseInt(event.target.dataset.row);
            const col = parseInt(event.target.dataset.col);

            if (board[row][col] === EMPTY) {
                makeMove(row, col, HUMAN);
                if (checkWin(HUMAN)) {
                    setStatus('Victory!', 'victory');
                    endGame();
                    return;
                }
                if (isDraw()) {
                    setStatus('It\'s a draw!', 'draw');
                    endGame();
                    return;
                }
                makeAIMove();
            }
        }

        function makeMove(row, col, player) {
            board[row][col] = player;
            const cell = document.querySelector(`.cell[data-row='${row}'][data-col='${col}']`);
            cell.textContent = player;
            cell.classList.add('taken');
        }

        function makeAIMove() {
            const { row, col } = alphaBeta(board, 0, true, -Infinity, Infinity);
            makeMove(row, col, AI);
            if (checkWin(AI)) {
                setStatus('You lose!', 'defeat');
                endGame();
                return;
            }
            if (isDraw()) {
                setStatus('It\'s a draw!', 'draw');
                endGame();
            }
        }

        function isDraw() {
            return board.every(row => row.every(cell => cell !== EMPTY));
        }

        function checkWin(player) {
            // Check rows, columns, and diagonals
            for (let i = 0; i < SIZE; i++) {
                for (let j = 0; j < SIZE; j++) {
                    if (
                        checkDirection(i, j, 0, 1, player) ||
                        checkDirection(i, j, 1, 0, player) ||
                        checkDirection(i, j, 1, 1, player) ||
                        checkDirection(i, j, 1, -1, player)
                    ) {
                        return true;
                    }
                }
            }
            return false;
        }

        function checkDirection(row, col, dRow, dCol, player) {
            let count = 0;
            for (let k = 0; k < 3; k++) {
                const r = row + k * dRow;
                const c = col + k * dCol;
                if (r >= 0 && r < SIZE && c >= 0 && c < SIZE && board[r][c] === player) {
                    count++;
                } else {
                    break;
                }
            }
            return count === 3;
        }

        function alphaBeta(board, depth, isMaximizing, alpha, beta) {
            if (checkWin(AI)) return { score: 10 - depth };
            if (checkWin(HUMAN)) return { score: depth - 10 };
            if (isDraw()) return { score: 0 };

            const moves = [];

            for (let i = 0; i < SIZE; i++) {
                for (let j = 0; j < SIZE; j++) {
                    if (board[i][j] === EMPTY) {
                        board[i][j] = isMaximizing ? AI : HUMAN;
                        const result = alphaBeta(board, depth + 1, !isMaximizing, alpha, beta);
                        moves.push({ row: i, col: j, score: result.score });
                        board[i][j] = EMPTY;

                        if (isMaximizing) {
                            alpha = Math.max(alpha, result.score);
                        } else {
                            beta = Math.min(beta, result.score);
                        }

                        if (beta <= alpha) {
                            break;
                        }
                    }
                }
            }

            if (isMaximizing) {
                return moves.reduce((best, move) => (move.score > best.score ? move : best), { score: -Infinity });
            } else {
                return moves.reduce((best, move) => (move.score < best.score ? move : best), { score: Infinity });
            }
        }

        function setStatus(message, className) {
            status.textContent = message;
            status.className = '';
            status.classList.add(className);
        }

        function endGame() {
            document.querySelectorAll('.cell').forEach(cell => cell.removeEventListener('click', handleHumanMove));
        }

        function restartGame() {
            board = Array(SIZE).fill(null).map(() => Array(SIZE).fill(EMPTY));
            status.textContent = '';
            status.className = '';
            createBoard();
        }

        createBoard();
    </script>
</body>
</html>
