import { Button } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types";
import { useState, type ComponentProps } from "react";

type WidthSelectorProps = Omit<ComponentProps<"div">, "defaultValue"> & {
  defaultValue: number;
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
      <ul className="divide-input flex h-6 flex-row divide-x overflow-hidden rounded-md border">
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
      <span className="text-accent-foreground pointer-events-none absolute left-1/2 top-1/2 z-10 -translate-x-1/2 -translate-y-1/2">
        {`${width}%`}
      </span>
    </div>
  );
}

export default WidthSelector;
