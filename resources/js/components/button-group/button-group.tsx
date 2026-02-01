import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import buttonGroupVariants from "./button-group-variants";

type ButtonGroupProps = ComponentProps<"div"> & VariantProps<typeof buttonGroupVariants>;

function ButtonGroup({ className, orientation, ...props }: ButtonGroupProps) {
  return (
    <div
      data-slot="button-group"
      role="group"
      data-orientation={orientation}
      className={cn(buttonGroupVariants({ orientation }), className)}
      {...props}
    />
  );
}

export default ButtonGroup;
