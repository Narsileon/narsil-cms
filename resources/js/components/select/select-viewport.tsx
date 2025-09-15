import { Select } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SelectViewportProps = React.ComponentProps<typeof Select.Content> & {};

function SelectViewport({
  className,
  position = "popper",
  ...props
}: SelectViewportProps) {
  return (
    <Select.Viewport
      className={cn(
        "p-1",
        position === "popper" &&
          "h-[var(--radix-select-trigger-height)] w-full scroll-my-1",
        className,
      )}
      {...props}
    />
  );
}

export default SelectViewport;
