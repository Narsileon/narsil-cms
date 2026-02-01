import { cn } from "@narsil-cms/lib/utils";
import { VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import inputGroupAddonVariants from "./input-group-addon-variants";

type InputGroupAddonProps = ComponentProps<"div"> & VariantProps<typeof inputGroupAddonVariants>;

function InputGroupAddon({ align = "inline-start", className, ...props }: InputGroupAddonProps) {
  return (
    <div
      data-slot="input-group-addon"
      data-align={align}
      className={cn(inputGroupAddonVariants({ align }), className)}
      role="group"
      onClick={(event) => {
        if ((event.target as HTMLElement).closest("button")) {
          return;
        }
        event.currentTarget.parentElement?.querySelector("input")?.focus();
      }}
      {...props}
    />
  );
}

export default InputGroupAddon;
