import { Separator } from "@/components/ui/separator";
import { TabsList, Tabs, TabsContent, TabsTrigger } from "@/components/ui/tabs";
import { useMinMd } from "@/hooks/use-breakpoints";
import { useRoute } from "ziggy-js";
import {
  Dialog,
  DialogCloseButton,
  DialogContent,
  DialogProps,
} from "@/components/ui/dialog";

type UserSettingsProps = {
  open: DialogProps["open"];
  onOpenChange: DialogProps["onOpenChange"];
};

function UserSettings({ open, onOpenChange }: UserSettingsProps) {
  const route = useRoute();

  const minMd = useMinMd();
  return (
    <>
      <Dialog open={open} onOpenChange={onOpenChange}>
        <DialogContent className="md:p-0" showCloseButton={false}>
          <Tabs
            defaultValue="general"
            orientation={minMd ? "vertical" : "horizontal"}
          >
            <TabsList className="md:border-r">
              {minMd ? <DialogCloseButton /> : null}
              <TabsTrigger value="general">General</TabsTrigger>
              <TabsTrigger value="account">Account</TabsTrigger>
            </TabsList>
            <Separator orientation={minMd ? "vertical" : "horizontal"} />
            <TabsContent value="general">General</TabsContent>
            <TabsContent value="account">Account</TabsContent>
          </Tabs>
        </DialogContent>
      </Dialog>
    </>
  );
}

export default UserSettings;
