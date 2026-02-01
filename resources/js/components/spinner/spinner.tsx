import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function Spinner({ className, ...props }: Omit<ComponentProps<typeof Icon>, "name">) {
  return (
    <Icon
      data-slot="spinner"
      role="status"
      className={cn("animate-spin", className)}
      aria-label="Loading"
      name="loader-circle"
      {...props}
    />
  );
}

export default Spinner;
