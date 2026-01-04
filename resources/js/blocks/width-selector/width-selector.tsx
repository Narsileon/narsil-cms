import { Button } from "@narsil-cms/blocks/button";
import { cn } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types";
import { useState, type ComponentProps } from "react";

type WidthSelectorProps = Omit<ComponentProps<"div">, "defaultValue"> & {
  defaultValue?: number;
  options: SelectOption[];
  value: number;
  onValueChange: (value: number) => void;
};

function WidthSelector({
  className,
  defaultValue = 100,
  options,
  value,
  onValueChange,
  ...props
}: WidthSelectorProps) {
  const [width, setWidth] = useState(value ?? defaultValue);

  return (
    <div
      className={cn("relative", className)}
      onMouseLeave={() => setWidth(value ?? defaultValue)}
      {...props}
    >
      <ul className="flex h-6 flex-row divide-x divide-input overflow-hidden rounded-md border">
        {options.map((option, index) => {
          const optionValue = Number(option.value);

          return (
            <li key={index}>
              <Button
                className={cn(
                  "w-2.5 rounded-none border-none p-0",
                  width >= optionValue && "bg-accent text-accent-foreground",
                )}
                variant="outline"
                onClick={() => onValueChange(optionValue)}
                onMouseEnter={() => setWidth(optionValue)}
              />
            </li>
          );
        })}
      </ul>
      <span className="pointer-events-none absolute top-1/2 left-1/2 z-10 -translate-x-1/2 -translate-y-1/2 text-accent-foreground">
        {`${width}%`}
      </span>
    </div>
  );
}

export default WidthSelector;
