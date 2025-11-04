from typing import Callable

def _if(condition, func1: Callable, func2: Callable):
    return func1() if condition else func2()

if __name__ == "__main__":
    assert _if(True,  lambda: "yes", lambda: "no") == "yes"
    assert _if(False, lambda: "yes", lambda: "no") == "no"

    print("All tests passed!")