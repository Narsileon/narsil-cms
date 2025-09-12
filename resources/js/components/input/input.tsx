import { cn } from "@narsil-cms/lib/utils";

type InputProps = React.ComponentProps<"input"> & {
  leftChildren?: React.ReactNode;
  children?: React.ReactNode;
  rightChildren?: React.ReactNode;
};

function Input({
  children,
  className,
  disabled,
  leftChildren,
  rightChildren,
  type,
  ...props
}: InputProps) {
  return (
    <div
      data-slot="input"
      className={cn(
        "flex h-9 w-full items-center justify-between gap-2 rounded-md border border-input bg-input/25 px-2 text-sm shadow-xs duration-300",
        "focus-within:border-ring focus-within:ring-2 focus-within:ring-ring/50",
        disabled && "pointer-events-none cursor-not-allowed opacity-50",
        className,
      )}
    >
      {leftChildren}
      <input
        className={cn(
          "h-full min-w-0 grow bg-transparent py-1 outline-none",
          "file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground",
          "selection:bg-primary selection:text-primary-foreground placeholder:text-muted-foreground",
          "[appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none",
        )}
        disabled={disabled}
        type={type}
        {...props}
      />
      {children}
      {rightChildren}
    </div>
  );
}

export default Input;
