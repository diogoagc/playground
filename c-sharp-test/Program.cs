using System;

class Program
{
    static char[,] board = 
    {
        { '1', '2', '3' },
        { '4', '5', '6' },
        { '7', '8', '9' }
    };

    static char currentPlayer = 'X';

    static void Main()
    {
        int turn = 0;
        bool gameWon = false;

        while (turn < 9 && !gameWon)
        {
            Console.Clear();
            DrawBoard();
            Console.Write($"Player {currentPlayer}, choose a position: ");
            
            if (int.TryParse(Console.ReadLine(), out int choice) && choice >= 1 && choice <= 9)
            {
                if (MakeMove(choice))
                {
                    gameWon = CheckWinner();
                    if (!gameWon)
                    {
                        currentPlayer = (currentPlayer == 'X') ? 'O' : 'X';
                    }
                    turn++;
                }
                else
                {
                    Console.WriteLine("Position already taken! Press Enter to retry...");
                    Console.ReadLine();
                }
            }
            else
            {
                Console.WriteLine("Invalid input! Press Enter to retry...");
                Console.ReadLine();
            }
        }

        Console.Clear();
        DrawBoard();
        
        if (gameWon)
            Console.WriteLine($"🎉 Player {currentPlayer} wins!");
        else
            Console.WriteLine("It's a draw!");

        Console.WriteLine("Press Enter to exit...");
        Console.ReadLine();
    }

    static void DrawBoard()
    {
        Console.WriteLine("Tic Tac Toe\n");
        for (int i = 0; i < 3; i++)
        {
            Console.WriteLine($" {board[i, 0]} | {board[i, 1]} | {board[i, 2]} ");
            if (i < 2) Console.WriteLine("---|---|---");
        }
        Console.WriteLine();
    }

    static bool MakeMove(int choice)
    {
        int row = (choice - 1) / 3;
        int col = (choice - 1) % 3;

        if (board[row, col] != 'X' && board[row, col] != 'O')
        {
            board[row, col] = currentPlayer;
            return true;
        }
        return false;
    }

    static bool CheckWinner()
    {
        // Check rows & columns
        for (int i = 0; i < 3; i++)
        {
            if ((board[i, 0] == board[i, 1] && board[i, 1] == board[i, 2]) || 
                (board[0, i] == board[1, i] && board[1, i] == board[2, i]))
                return true;
        }

        // Check diagonals
        if ((board[0, 0] == board[1, 1] && board[1, 1] == board[2, 2]) ||
            (board[0, 2] == board[1, 1] && board[1, 1] == board[2, 0]))
            return true;

        return false;
    }
}
