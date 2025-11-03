import streamlit as st
from src.fibonacci_viewer import fib_under

st.set_page_config(page_title="Fibonacci Viewer", layout="centered")

st.title("Fibonacci Viewer")
st.write("Generate Fibonacci numbers below a maximum value, and optionally visualize them.")

max_value = st.number_input(
    "Upper limit (exclusive)", min_value=0, value=100, step=1, help="All Fibonacci numbers will be < this value."
)
show_plot = st.checkbox("Show graph")

seq = fib_under(int(max_value))

if not seq:
    st.info(f"No Fibonacci numbers below {max_value}.")
else:
    st.subheader(f"Fibonacci numbers below {max_value} ({len(seq)} total)")
    # Pretty columns display
    st.code("\n".join(f"{i+1:>3}: {v}" for i, v in enumerate(seq)), language="text")

    if show_plot:
        st.subheader("Chart")
        # Use Streamlit's built-in chart (index vs value)
        st.line_chart({"Fibonacci(n)": seq})
