__all__ = ["fib_under"]

def fib_under(n: int) -> list[int]:
    """Return all Fibonacci numbers strictly less than n."""
    if n <= 1:
        return [0] if n > 0 else []
    seq = [0, 1]
    while seq[-1] + seq[-2] < n:
        seq.append(seq[-1] + seq[-2])
    return seq
