import argparse
from . import fib_under

def main(argv=None):
    parser = argparse.ArgumentParser(
        description="Display Fibonacci numbers under a given limit, with optional graph."
    )
    parser.add_argument("--max", "-m", type=int, help="Upper limit (exclusive).")
    parser.add_argument("--plot", action="store_true", help="Show a simple plot.")
    args = parser.parse_args(argv)

    max_value = args.max
    if max_value is None:
        raw = input("Enter a positive integer limit: ").strip()
        try:
            max_value = int(raw)
        except ValueError:
            print("Invalid input. Please enter a number.")
            return 1

    if max_value < 0:
        print("Please provide a non-negative number.")
        return 1

    seq = fib_under(max_value)

    if not seq:
        print(f"No Fibonacci numbers below {max_value}.")
    else:
        print(f"Fibonacci numbers below {max_value} ({len(seq)} total):")
        width = len(str(seq[-1])) if seq else 1
        for i, v in enumerate(seq, start=1):
            print(f"{i:>3}: {v:>{width}}")

    if args.plot and seq:
        try:
            import matplotlib.pyplot as plt
        except Exception:
            print("matplotlib not installed. Try:\n  python -m pip install matplotlib")
            return 1

        xs = list(range(len(seq)))
        ys = seq
        plt.figure()
        plt.plot(xs, ys, marker="o")
        plt.title(f"Fibonacci Numbers Below {max_value}")
        plt.xlabel("Index (n)")
        plt.ylabel("Fibonacci(n)")
        plt.grid(True)
        plt.show()

    return 0
