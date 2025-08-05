import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { ModalLink } from "@narsil-cms/components/ui/modal";

type SortableCreateProps = React.ComponentProps<typeof ModalLink> & {};

function SortableCreate({ className, ...props }: SortableCreateProps) {
  return (
    <Button
      className={cn("h-11 w-fit cursor-grab place-self-center")}
      asChild={true}
      variant="ghost"
    >
      <ModalLink
        options={{
          onSuccess: (response) => {
            console.log(response);
          },
        }}
        {...props}
      >
        Create
      </ModalLink>
    </Button>
  );
}

export default SortableCreate;
