import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types/forms";

type WidthSelectorProps = React.ComponentProps<"div"> & {
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
  const [width, setWidth] = React.useState(value ?? defaultValue);

  return (
    <div
      className={cn("relative", className)}
      onMouseLeave={() => setWidth(value ?? defaultValue)}
      {...props}
    >
      <ul className="divide-input flex h-6 flex-row divide-x overflow-hidden rounded-md border">
        {options.map((option, index) => (
          <li>
            <Button
              className={cn(
                "w-2.5 rounded-none border-none p-0",
                width >= option.value && "bg-accent text-accent-foreground",
              )}
              variant="outline"
              onClick={() => onValueChange(option.value)}
              onMouseEnter={() => setWidth(option.value)}
              key={index}
            />
          </li>
        ))}
      </ul>
      <span className="text-accent-foreground pointer-events-none absolute top-1/2 left-1/2 z-10 -translate-x-1/2 -translate-y-1/2 text-sm">
        {`${width}%`}
      </span>
    </div>
  );
}

export default WidthSelector;
