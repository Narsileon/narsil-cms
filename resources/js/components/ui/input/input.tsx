import * as React from "react";
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
        "border-input bg-input/25 flex h-9 w-full items-center justify-between gap-2 rounded-md border px-2 text-sm shadow-xs",
        "focus-within:border-ring focus-within:ring-ring/50 focus-within:ring-[3px]",
        "aria-invalid:ring-destructive/20 aria-invalid:border-destructive dark:aria-invalid:ring-destructive/40",
        disabled && "pointer-events-none cursor-not-allowed opacity-50",
        className,
      )}
    >
      {leftChildren}
      <input
        className={cn(
          "h-full min-w-0 grow bg-transparent py-1 outline-none",
          "file:text-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium",
          "placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground",
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
