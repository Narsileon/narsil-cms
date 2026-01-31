import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function Spinner({ className, ...props }: Omit<ComponentProps<typeof Icon>, "name">) {
  return (
    <Icon
      aria-label="Loading"
      data-slot="spinner"
      className={cn("animate-spin", className)}
      name="loader-circle"
      role="status"
      {...props}
    />
  );
}

export default Spinner;
