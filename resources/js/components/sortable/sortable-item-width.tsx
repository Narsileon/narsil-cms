import { useState } from "react";

import { Button } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";
import { type SelectOption } from "@narsil-cms/types";

type SortableItemWidthProps = React.ComponentProps<"div"> & {
  options: SelectOption[];
  value: number;
  onValueChange: (value: number) => void;
};

function SortableItemWidth({
  className,
  defaultValue = 100,
  options,
  value,
  onValueChange,
  ...props
}: SortableItemWidthProps) {
  const [width, setWidth] = useState(value ?? defaultValue);

  return (
    <div
      className={cn("relative", className)}
      onMouseLeave={() => setWidth(value ?? defaultValue)}
      {...props}
    >
      <ul className="flex h-6 flex-row divide-x divide-input overflow-hidden rounded-md border">
        {options.map((option, index) => (
          <li key={index}>
            <Button
              className={cn(
                "w-2.5 rounded-none border-none p-0",
                width >= option.value && "bg-accent text-accent-foreground",
              )}
              variant="outline"
              onClick={() => onValueChange(option.value)}
              onMouseEnter={() => setWidth(option.value)}
            />
          </li>
        ))}
      </ul>
      <span className="pointer-events-none absolute top-1/2 left-1/2 z-10 -translate-x-1/2 -translate-y-1/2 text-sm text-accent-foreground">
        {`${width}%`}
      </span>
    </div>
  );
}

export default SortableItemWidth;
